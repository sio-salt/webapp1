<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeYamadai extends Command
{
    const BASE_URL = 'https://www.yamagata-u.ac.jp/gakumu/syllabus/2023/'; // 山形大学の学部のシラバスのトップページbase_url
    const CHAR_SET = 'Shift-JIS';
    const WAIT_TIME = 10;

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
        $client = new Client();
        $response = $client->request('GET', $this::BASE_URL . 'home.htm');
        $html = '' . $response->getBody();
        $html = mb_convert_encoding($html, 'UTF-8', $this::CHAR_SET); // エンコーディングを変換
        $crawler = new Crawler($html);
        $faculty_urls = array();
        $this::WAIT_TIME;

        // 学部トップページの中の学部ループ
        $crawler->filter('a')->each(function (Crawler $node) use ($client, &$faculty_urls) {
            $href = $node->attr('href');
            if (!preg_match('/\d+sylla\.htm/', $href))
                return false;

            array_push($faculty_urls, $href);
            $response = $client->request('GET', $this::BASE_URL . $href);
            $this::WAIT_TIME;
            $html = '' . $response->getBody();
            $crawler = new Crawler($html);
            $class_list_url = $crawler->filter('frameset > frameset > frame:first-child')->attr('src');
            $response = $client->request('GET', $this::BASE_URL . $class_list_url);
            $html = '' . $response->getBody();
            $html = mb_convert_encoding($html, 'UTF-8', $this::CHAR_SET); // エンコーディングを変換
            $crawler = new Crawler($html);
            $faculty_name = $crawler->filter('body > p')->first()->text();
            // dump($faculty_name);
            $this::WAIT_TIME;

            // その学部の人が受けられる講義の種類のループ
            $crawler->filter('a[target="list"]')->each(function (Crawler $node) use ($client) {
                $href = $node->attr('href');
                if (!preg_match('/list\d+\.htm/', $href))
                    return false;

                $response = $client->request('GET', $this::BASE_URL . $href);
                $html = '' . $response->getBody();
                $crawler = new Crawler($html);
                $crawler->filter('tr')->each(function (Crawler $node) use ($client) {
                    if ($node->filter('td')->count() < 5)
                        return false;

                    $tds = $node->filter('td');
                    $lecture_info = [
                        'code' => $tds->eq(0)->text(),
                        'semester' => $tds->eq(1)->text(),
                        'subject' => $tds->eq(2)->text(),
                        'teacher' => $tds->eq(3)->text(),
                        'year' => $tds->eq(4)->text(),
                        'form' => $tds->eq(5)->text(),
                    ];
                    $this::WAIT_TIME;
                });
            });
        });
        return Command::SUCCESS;
    }
}
