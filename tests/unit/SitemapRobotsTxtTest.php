<?php

namespace WP2Static;

use PHPUnit\Framework\TestCase;

class SitemapRobotsTxtTest extends TestCase {

    /**
     * @group ExternalRequests
     * @dataProvider generateDataForTest
     * @param string $url URL
     * @param string $body URL body content
     * @param array $result Test result to match
     */
    public function testRobotsTxt( $url, $body, $result ) {
        $parser = new SitemapParser( 'SitemapParser' );
        $this->assertInstanceOf( 'WP2Static\SitemapParser', $parser );
        $parser->parse( $url, $body );
        $this->assertEquals( $result, $parser->getSitemaps() );
        $this->assertEquals( [], $parser->getURLs() );
    }

    /**
     * Generate test data
     *
     * @return array
     */
    public function generateDataForTest() {
        return [
            [
                'http://www.example.com/robots.txt',
                <<<ROBOTSTXT
User-agent: *
Disallow: /
#Sitemap:http://www.example.com/sitemap.xml.gz
  Sitemap:http://www.example.com/sitemap.xml#comment
ROBOTSTXT
                ,
                $result = [
                    'http://www.example.com/sitemap.xml' => [
                        'loc' => 'http://www.example.com/sitemap.xml',
                        'lastmod' => null,
                    ],
                ],
            ],
        ];
    }
}
