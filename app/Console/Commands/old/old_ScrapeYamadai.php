<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;


class old_ScrapeYamadai extends Command
{
    const BASE_URL = 'https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/'; // 山形大学の学部のシラバスのトップページbase_url
    const CHAR_SET = 'Shift-JIS';
    const WAIT_TIME = 6;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:yamadai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape Yamagata University Syllabus';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
// $str = 'ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩⅰⅱⅲⅳⅴⅵⅶⅷⅸⅹ①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳№㈲㈱㈹㊤㊦㊥㊧㊨';

        $this->insertLectures();
    }

    private function insertLectures()
    {
        $client = new Client();
        sleep($this::WAIT_TIME);
        $response = $client->request('GET', $this::BASE_URL . 'home.htm');
        $html = '' . $response->getBody();
        $html = mb_convert_encoding($html, 'UTF-8', $this::CHAR_SET); // エンコーディングを変換
        $crawler = new Crawler($html);
        $faculty_urls = array();

        // 学部トップページの中の学部ループ
        $crawler->filter('a')->each(function (Crawler $node) use ($client, &$faculty_urls)
        {
            $href = $node->attr('href');
            if (!preg_match('/\d+sylla\.htm/', $href))
                return false;

            array_push($faculty_urls, $href);
            sleep($this::WAIT_TIME);
            $response = $client->request('GET', $this::BASE_URL . $href);
            $html = '' . $response->getBody();
            $crawler = new Crawler($html);
            $class_list_url = $crawler->filter('frameset > frameset > frame:first-child')->attr('src');
            sleep($this::WAIT_TIME);
            $response = $client->request('GET', $this::BASE_URL . $class_list_url);
            $html = '' . $response->getBody();
            // $html = mb_convert_encoding($html, 'UTF-8', $this::CHAR_SET); // エンコーディングを変換
            // $html = mb_convert_encoding($html, 'UTF-8', 'auto'); // エンコーディングを変換
            $crawler = new Crawler($html);
            // $faculty_name = $crawler->filter('body > p')->first()->text();
            // dump($faculty_name);

            // その学部の人が受けられる講義の種類のループ
            $crawler->filter('a[target="list"]')->each(function (Crawler $node) use ($client)
            {
                $href = $node->attr('href');
                echo $href . PHP_EOL;
                // if (!preg_match('/\Alist\d+\.htm\z/', $href) || preg_match('/.*pdf/', $href))
                if (!preg_match('/\Alist\d+\.htm\z/', $href))
                    return false;

                sleep($this::WAIT_TIME);
                $response = $client->request('GET', $this::BASE_URL . $href);
                $html = '' . $response->getBody();
                $crawler = new Crawler($html);
                $lectures = $crawler->filter('tr')->each(function (Crawler $node) use ($client)
                {
                    if ($node->filter('td')->count() != 7)
                        return false;

                    $tds = $node->filter('td');
                    $lecture = [
                        'code' => $tds->eq(0)->text(),
                        'semester' => $tds->eq(1)->text(),
                        'subject' => $tds->eq(2)->text(),
                        'teacher' => $tds->eq(3)->text(),
                        'year' => $tds->eq(4)->text(),
                        'form' => $tds->eq(5)->text(),
                    ];
                    $tmp = implode(", ", $lecture);
                    return $tmp . "\n";
                });
                // DB::table('lectures')->insert($lectures);
                // $text = implode("\n", $lectures);
                file_put_contents('file.txt', $lectures, FILE_APPEND);
            });
        });
        return Command::SUCCESS;
    }
}


























// namespace App\Console\Commands;

// use Illuminate\Console\Command;
// use GuzzleHttp\Client;
// use Symfony\Component\DomCrawler\Crawler;
// use Illuminate\Support\Facades\DB;
// use App\Libs\CharacterEncoding; // 追加

// class ScrapeYamadai extends Command
// {
//     const BASE_URL = 'https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/'; // 山形大学の学部のシラバスのトップページbase_url
//     const CHAR_SET = 'Shift-JIS';
//     const WAIT_TIME = 6;

//     /**
//      * The name and signature of the console command.
//      *
//      * @var string
//      */
//     protected $signature = 'scrape:yamadai';

//     /**
//      * The console command description.
//      *
//      * @var string
//      */
//     protected $description = 'Scrape Yamagata University Syllabus';

//     /**
//      * Execute the console command.
//      *
//      * @return int
//      */
//     public function handle()
//     {
//         $this->insertLectures();
//     }

//     private function insertLectures()
//     {
//         $client = new Client();
//         sleep($this::WAIT_TIME);
//         $response = $client->request('GET', $this::BASE_URL . 'home.htm');
//         $html = '' . $response->getBody();
//         $html = mb_convert_encoding($html, 'UTF-8', $this::CHAR_SET); // エンコーディングを変換
//         $html = $this->replaceMachineChar($html); // 追加
//         $crawler = new Crawler($html);
//         $faculty_urls = array();

//         // 学部トップページの中の学部ループ
//         $crawler->filter('a')->each(function (Crawler $node) use ($client, &$faculty_urls) // 追加
//         {
//             $href = $node->attr('href');
//             if (!preg_match('/\d+sylla\.htm/', $href))
//                 return false;

//             array_push($faculty_urls, $href);
//             sleep($this::WAIT_TIME);
//             $response = $client->request('GET', $this::BASE_URL . $href);
//             $html = '' . $response->getBody();
//             $html = $this->replaceMachineChar($html); // 追加
//             $crawler = new Crawler($html);
//             $class_list_url = $crawler->filter('frameset > frameset > frame:first-child')->attr('src');
//             sleep($this::WAIT_TIME);
//             $response = $client->request('GET', $this::BASE_URL . $class_list_url);
//             $html = '' . $response->getBody();
//             $html = $this->replaceMachineChar($html); // 追加
//             $crawler = new Crawler($html);

//             // その学部の人が受けられる講義の種類のループ
//             $crawler->filter('a[target="list"]')->each(function (Crawler $node) use ($client) // 追加
//             {
//                 $href = $node->attr('href');
//                 echo $href . PHP_EOL;
//                 if (!preg_match('/\Alist\d+\.htm\z/', $href))
//                     return false;

//                 sleep($this::WAIT_TIME);
//                 $response = $client->request('GET', $this::BASE_URL . $href);
//                 $html = '' . $response->getBody();
//                 $html = $this->replaceMachineChar($html); // 追加
//                 $crawler = new Crawler($html);
//                 $lectures = $crawler->filter('tr')->each(function (Crawler $node) use ($client) // 追加
//                 {
//                     if ($node->filter('td')->count() != 7)
//                         return false;

//                     $tds = $node->filter('td');
//                     $lecture = [
//                         'code' => $this->replaceMachineChar($tds->eq(0)->text()), // 追加
//                         'semester' => $this->replaceMachineChar($tds->eq(1)->text()), // 追加
//                         'subject' => $this->replaceMachineChar($tds->eq(2)->text()), // 追加
//                         'teacher' => $this->replaceMachineChar($tds->eq(3)->text()), // 追加
//                         'year' => $this->replaceMachineChar($tds->eq(4)->text()), // 追加
//                         'form' => $this->replaceMachineChar($tds->eq(5)->text()), // 追加
//                     ];
//                     $tmp = implode(", ", $lecture);
//                     return $tmp . "\n";
//                 });
//                 file_put_contents('file.txt', $lectures, FILE_APPEND);
//                 // echo implode(", \n", $lectures) . PHP_EOL;
//             });
//         });
//         return Command::SUCCESS;
//     }



//     private function replaceMachineChar(string $str): string
//     {
//         // 現在の文字コードを取得
//         // $_encode = mb_detect_encoding($str);
//         $_encode = 'euc-jp';

//         // SJIS-winに変換
//         if ($_encode != "SJIS-win") {
//             mb_convert_encoding($str, "SJIS-win", $_encode);
//         }

//         $search = array(
//             'Ⅰ', 'Ⅱ', 'Ⅲ', 'Ⅳ', 'Ⅴ', 'Ⅵ', 'Ⅶ', 'Ⅷ', 'Ⅸ', 'Ⅹ',
//             'ⅰ', 'ⅱ', 'ⅲ', 'ⅳ', 'ⅴ', 'ⅵ', 'ⅶ', 'ⅷ', 'ⅸ', 'ⅹ',
//             '①', '②', '③', '④', '⑤', '⑥', '⑦', '⑧', '⑨', '⑩',
//             '⑪', '⑫', '⑬', '⑭', '⑮', '⑯', '⑰', '⑱', '⑲', '⑳',
//             '№', '㈲', '㈱', '㈹',
//             '㊤', '㊦', '㊥', '㊧', '㊨',
//             '髙', '﨑', '彅', '塚', '增', '寬', '敎', '晴', '朗', '﨔', '橫', '德', '瀨',
//             '淸', '瀨', '凞', '猪', '益', '礼', '神', '祥', '福', '靖', '精', '濵', '琦', '昻',
//             '緖', '羽', '薰', '諸', '賴', '逸', '郞', '都', '鄕', '閒', '隆', '靑', '飯', '飼', '館',
//             '鶴', '黑',
//             '㍉', '㌔', '㌢', '㍍', '㌘', '㌧', '㌃', '㌶', '㍑',
//             '㍗', '㌍', '㌦', '㌣', '㌫', '㍊', '㌻',
//             '㎜', '㎝', '㎞', '㎏', '㏄', '㎡',
//             '㍻', '〝', '〟', '℡', '㍾', '㍽', '㍼', '㏍'
//         );

//         $replace = array(
//             'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X',
//             'i', 'ii', 'iii', 'vi', 'v', 'vi', 'vii', 'viii', 'ix', 'x',
//             '(1)', '(2)', '(3)', '(4)', '(5)', '(6)', '(7)', '(8)', '(9)', '(10)',
//             '(11)', '(12)', '(13)', '(14)', '(15)', '(16)', '(17)', '(18)', '(19)', '(20)',
//             'No.', '（有）', '（株）', '(代)',
//             '(上)', '(下)', '(中)', '(左)', '(右)',
//             '高', '崎', 'なぎ', '塚', '増', '寛', '教', '晴', '朗', '欅', '横', '徳', '瀬',
//             '清', '瀬', '煕', '猪', '益', '礼', '神', '祥', '福', '靖', '精', '濱', '埼', '昂',
//             '緒', '羽', '薫', '諸', '頼', '逸', '郎', '都', '郷', '間', '隆', '青', '飯', '飼', '館',
//             '鶴', '黒',
//             'ミリ', 'キロ', 'センチ', 'メートル', 'グラム', 'トン', 'アール', 'ヘクタール', 'リットル',
//             'ワット', 'カロリー', 'ドル', 'セント', 'パーセント', 'ミリバール', 'ページ',
//             'mm', 'cm', 'km', 'kg', 'cc', '平方メートル',
//             '平成', '"', '"', 'TEL', '明治', '大正', '昭和', 'K.K.'
//         );

//         $result = str_replace($search, $replace, $str);
//         // 半角カナを全角カナ 全角英字を半角英字
//         // $result = mb_convert_kana($result, "KV");

//         // 機種依存文字を変換
//         // $ret = str_replace($search, $replace, $str);
//         // UTF-8に変換
//         // $result = mb_convert_encoding($ret, 'UTF-8', "SJIS-win");

//         return $result;
//     }


// }
