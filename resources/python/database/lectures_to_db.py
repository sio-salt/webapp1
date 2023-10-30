# 参考URL
# https://alctail.sakura.ne.jp/contents/pg/db/python_mariadb/#section5

import mariadb
import mariadb.constants


lecture_names = []
with open('4.text_classes_v4.txt', 'r') as f:
    for line in f.readlines():
        lecture_names.append(line.strip())


# DBのコネクションを返す
def createConnection():
    # DB接続オブジェクトを返す
    try:
        global conn
        conn = mariadb.connect(
                user='dbuser',             # MariaDBのユーザーID
                password='3Sa8la5ga2ta',   # MariaDBのrootユーザーのパスワード
                host='localhost',          # MariaDBのサーバーアドレス
                port=3306,                 # MariaDBのポート番号
                database='webapp',         # デフォルトで使用するDB
                autocommit=True            # autocommitを使用する(デフォルトではFalse)
            )
    except mariadb.Error as e:
        print(f"DB接続エラー:{e}")
        return None
    return conn


# insertを実行
def execInsert(conn):
    sql = "INSERT INTO lectures (name) values (?)"
    cur = conn.cursor()
    try:
        for lec_name in lecture_names:
            cur.execute(sql, (lec_name,))
    except Exception as e:
        print(f"insertの処理に失敗しました:{e}")
    finally:
        cur.close()





createConnection()
execInsert(conn)

conn.close()

