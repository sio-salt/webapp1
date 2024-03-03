# import requests
# from bs4 import BeautifulSoup

# # URLからHTMLを取得
# url = "https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1139.htm"
# response = requests.get(url)

# # HTMLをBeautiful Soupで解析
# soup = BeautifulSoup(response.content, "html.parser")

# # 例: <body>内の3番目の<tr>の中身を取得
# tr_elements = soup.find_all("tr")
# if len(tr_elements) >= 3:
#     third_tr_content = tr_elements[2].text.strip()
#     print("3番目の<tr>の中身:", third_tr_content)
# else:
#     print("3番目の<tr>が存在しません。")





# import requests
# from bs4 import BeautifulSoup
# import csv

# # URLリストを定義
# urls = ["https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1110.htm",
#         "https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1139.htm"]

# # CSVファイルを開く
# with open('output.csv', 'w', newline='') as file:
#     writer = csv.writer(file)

#     # 各URLについて処理を行う
#     for url in urls:
#         # URLからHTMLを取得
#         response = requests.get(url)

#         # HTMLをBeautiful Soupで解析
#         soup = BeautifulSoup(response.content, "html.parser")

#         # 例: <body>内の3番目の<tr>の中身を取得
#         tr_elements = soup.find_all("tr")
#         if len(tr_elements) >= 3:
#             third_tr_content = tr_elements[2].text.strip()
#             print(f"3番目の<tr>の中身 ({url}):", third_tr_content)

#             # CSVファイルに書き込む
#             writer.writerow([url, third_tr_content])
#         else:
#             print(f"3番目の<tr>が存在しません ({url}).")







import requests
from bs4 import BeautifulSoup
import csv

# URLリストを定義
urls = ["https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1110.htm",
        "https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/list1139.htm"]

# CSVファイルを開く
with open('output.csv', 'w', newline='', encoding='utf-8') as file:
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
