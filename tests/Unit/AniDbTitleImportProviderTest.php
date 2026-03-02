<?php

namespace Tests\Unit;

use App\Enums\AnimeTitleTypeEnum;
use App\Services\TitleImport\Providers\AniDbTitleImportProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class AniDbTitleImportProviderTest extends TestCase
{
    public function test_anime_title_type_from_anidb(): void
    {
        $this->assertEquals(AnimeTitleTypeEnum::Main, AnimeTitleTypeEnum::fromAniDbType('main'));
        $this->assertEquals(AnimeTitleTypeEnum::Official, AnimeTitleTypeEnum::fromAniDbType('official'));
        $this->assertEquals(AnimeTitleTypeEnum::Syn, AnimeTitleTypeEnum::fromAniDbType('syn'));
        $this->assertEquals(AnimeTitleTypeEnum::Short, AnimeTitleTypeEnum::fromAniDbType('short'));
        $this->assertEquals(AnimeTitleTypeEnum::Syn, AnimeTitleTypeEnum::fromAniDbType('unknown'));
    }

    public function test_parse_anime_titles_returns_empty_for_unknown_anidb_id(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<animetitles>
    <anime aid="1">
        <title xml:lang="uk" type="official">Ковбой Бібоп</title>
    </anime>
</animetitles>
XML;

        $provider = $this->makeProvider();
        $results = $this->callParseAnimeTitles($provider, $xml, 99999);

        $this->assertCount(0, $results);
    }

    public function test_parse_anime_titles_returns_empty_when_no_uk_titles(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<animetitles>
    <anime aid="16498">
        <title xml:lang="en" type="official">Attack on Titan</title>
        <title xml:lang="ja" type="official">進撃の巨人</title>
    </anime>
</animetitles>
XML;

        $provider = $this->makeProvider();
        $results = $this->callParseAnimeTitles($provider, $xml, 16498);

        $this->assertCount(0, $results);
    }

    public function test_parse_anime_titles_returns_uk_titles(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<animetitles>
    <anime aid="16498">
        <title xml:lang="x-jat" type="main">Shingeki no Kyojin</title>
        <title xml:lang="en" type="official">Attack on Titan</title>
        <title xml:lang="uk" type="official">Атака Титанів</title>
        <title xml:lang="uk" type="syn">Атака Гігантів</title>
    </anime>
    <anime aid="1">
        <title xml:lang="uk" type="official">Ковбой Бібоп</title>
    </anime>
</animetitles>
XML;

        $provider = $this->makeProvider();
        $results = $this->callParseAnimeTitles($provider, $xml, 16498);

        $this->assertCount(2, $results);

        $this->assertEquals('Атака Титанів', $results[0]->title);
        $this->assertEquals(AnimeTitleTypeEnum::Official, $results[0]->source);

        $this->assertEquals('Атака Гігантів', $results[1]->title);
        $this->assertEquals(AnimeTitleTypeEnum::Syn, $results[1]->source);
    }

    public function test_parse_episode_title_returns_null_for_unknown_episode(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<anime id="1">
    <episodes>
        <episode id="100">
            <epno type="1">1</epno>
            <title xml:lang="uk">Перший епізод</title>
        </episode>
    </episodes>
</anime>
XML;

        $provider = $this->makeProvider();
        $result = $this->callParseEpisodeTitle($provider, $xml, 99);

        $this->assertNull($result);
    }

    public function test_parse_episode_title_returns_null_when_no_uk_title(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<anime id="16498">
    <episodes>
        <episode id="101">
            <epno type="1">2</epno>
            <title xml:lang="en">That Day</title>
            <title xml:lang="ja">その日</title>
        </episode>
    </episodes>
</anime>
XML;

        $provider = $this->makeProvider();
        $result = $this->callParseEpisodeTitle($provider, $xml, 2);

        $this->assertNull($result);
    }

    public function test_parse_episode_title_returns_uk_title(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<anime id="16498">
    <episodes>
        <episode id="100">
            <epno type="1">1</epno>
            <title xml:lang="en">To You, in 2000 Years</title>
            <title xml:lang="uk">До тебе, через 2000 років</title>
        </episode>
        <episode id="101">
            <epno type="1">2</epno>
            <title xml:lang="en">That Day</title>
        </episode>
    </episodes>
</anime>
XML;

        $provider = $this->makeProvider();
        $result = $this->callParseEpisodeTitle($provider, $xml, 1);

        $this->assertNotNull($result);
        $this->assertEquals('До тебе, через 2000 років', $result->titleUk);
    }

    public function test_parse_episode_title_skips_non_regular_episodes(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<anime id="1">
    <episodes>
        <episode id="200">
            <epno type="2">1</epno>
            <title xml:lang="uk">Спешл епізод</title>
        </episode>
    </episodes>
</anime>
XML;

        $provider = $this->makeProvider();
        $result = $this->callParseEpisodeTitle($provider, $xml, 1);

        $this->assertNull($result);
    }

    private function callParseAnimeTitles(AniDbTitleImportProvider $provider, string $xml, int $anidbId): array
    {
        $parsedXml = simplexml_load_string($xml);
        $method = new ReflectionMethod($provider, 'parseAnimeTitles');

        return $method->invoke($provider, $parsedXml, $anidbId);
    }

    private function callParseEpisodeTitle(AniDbTitleImportProvider $provider, string $xml, int $episodeNumber): mixed
    {
        $parsedXml = simplexml_load_string($xml);
        $method = new ReflectionMethod($provider, 'parseEpisodeTitle');

        return $method->invoke($provider, $parsedXml, $episodeNumber);
    }

    private function makeProvider(): AniDbTitleImportProvider
    {
        return new AniDbTitleImportProvider(client: 'testclient', clientVer: '1');
    }
}
