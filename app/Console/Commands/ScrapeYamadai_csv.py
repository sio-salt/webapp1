import requests
from bs4 import BeautifulSoup
import time
import csv

BASE_URL = 'https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/' # 山形大学の学部のシラバスのトップページbase_url
WAIT_TIME = 6
PYTHON_PATH = './app/Console/Commands/'

def insert_lectures():
    faculty_urls = []
    response = requests.get(BASE_URL + 'home.htm')
    # html = response.content.decode('shift_jis')
    soup = BeautifulSoup(response.content, 'html.parser')

    # 学部トップページの中の学部ループ
    for a in soup.find_all('a'):
        href = a.get('href')
        if not href or not href.endswith('sylla.htm'):
            continue

        faculty_urls.append(href)
        time.sleep(WAIT_TIME)
        response = requests.get(BASE_URL + href)
        # html = response.content.decode('shift_jis')
        soup = BeautifulSoup(response.content, 'html.parser')
        class_list_url = soup.select_one('frameset > frameset > frame:first-child').get('src')

        time.sleep(WAIT_TIME)
        response = requests.get(BASE_URL + class_list_url)
        # html = response.content.decode('shift_jis')
        soup = BeautifulSoup(response.content, 'html.parser')

        # その学部の人が受けられる講義の種類のループ
        for a in soup.select('a[target="list"]'):
            href = a.get('href')
            # print(href)
            if not href or not href.startswith('list') or not href.endswith('.htm'):
                continue

            with open(PYTHON_PATH + 'file.txt', 'a', newline='') as f:
                writer = csv.writer(f)
                writer.writerows([href])
            time.sleep(WAIT_TIME)
            response = requests.get(BASE_URL + href)
            # html = response.content.decode('shift_jis')
            soup = BeautifulSoup(response.content, 'html.parser')
            lectures = []
            for tr in soup.find_all('tr'):
                tds = tr.find_all('td')
                if len(tds) != 7:
                    continue

                lecture = tr.text.strip().split('\n')
                # lecture = {
                #     'code': tds[0].text,
                #     'semester': tds[1].text,
                #     'subject': tds[2].text,
                #     'teacher': tds[3].text,
                #     'year': tds[4].text,
                #     'form': tds[5].text,
                # }
                lectures.append(lecture)

            # with open(PYTHON_PATH + 'file.txt', 'a', newline='') as f:
            #     writer = csv.writer(f)
            #     # writer = csv.DictWriter(f, fieldnames=lectures[0].keys())
            #     writer.writerows(lectures)
            # URLリストを定義
            urls = ["https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1110.htm",
                    "https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1139.htm"]

# CSVファイルを開く
            with open(PYTHON_PATH + 'file.txt', 'a', newline='') as file:
                writer = csv.writer(file)

                # 各URLについて処理を行う
                for url in urls:
                    # URLからHTMLを取得
                    response = requests.get(url)

                    # HTMLをBeautiful Soupで解析
                    soup = BeautifulSoup(response.content, "html.parser")

                    # 例: <body>内の3番目の<tr>の中身を取得
                    tr_elements = soup.find_all("tr")
                    if len(tr_elements) >= 3:
                        third_tr_content = tr_elements[2].text.strip()
                        # print(tr_elements[2].text)
                        # print(f"3番目の<tr>の中身 ({url}):", third_tr_content)

                        # CSVファイルに書き込む
                        # 文字列を改行で分割してリストに変換
                        content_list = third_tr_content.split("\n")
                        writer.writerow(content_list)
                    else:
                        # print(f"3番目の<tr>が存在しません ({url}).")
                        pass


def main():
    insert_lectures()

if __name__ == '__main__':
    main()

