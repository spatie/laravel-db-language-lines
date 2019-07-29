<?php

namespace Spatie\TranslationLoader\Test;

use Illuminate\Support\Arr;

class TransJsonTest extends TestCase
{
    const TERM1 = 'file not found';
    const TERM1_EN = 'File not found in en';
    const TERM1_NL = 'File not found in nl';
    const TERM1_EN_DB = 'File not found in en from db';
    const TERM1_NL_DB = 'File not found in nl from db';
    const TERM2 = 'file not found. it might be in trash.';
    const TERM2_EN = 'File not found in en. It might be in trash.';
    const TERM2_NL = 'File not found in nl. It might be in trash.';
    const TERM2_EN_DB = 'File not found in en from db. It might be in trash.';
    const TERM2_NL_DB = 'File not found in nl from db. It might be in trash.';

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_get_translations_for_language_files()
    {
        $this->assertEquals(self::TERM1_EN, __(self::TERM1));
        $this->assertEquals(self::TERM2_EN, __(self::TERM2));
    }

    /** @test */
    public function it_can_get_translations_for_language_files_for_the_current_locale()
    {
        app()->setLocale('nl');

        $this->assertEquals(self::TERM1_NL, __(self::TERM1));
        $this->assertEquals(self::TERM2_NL, __(self::TERM2));
    }

    /** @test */
    public function by_default_it_will_prefer_a_db_translation_over_a_file_translation()
    {
        $this->createLanguageLine('*', self::TERM1, ['en' => self::TERM1_EN_DB]);
        $this->createLanguageLine('*', self::TERM2, ['en' => self::TERM2_EN_DB]);

        $this->assertEquals(self::TERM1_EN_DB, __(self::TERM1));
        $this->assertEquals(self::TERM2_EN_DB, __(self::TERM2));
    }

    /** @test */
    public function it_will_default_to_fallback_if_locale_is_missing()
    {
        app()->setLocale('de');
        $this->createLanguageLine('*', self::TERM1, ['en' => self::TERM1_EN_DB]);

        $this->assertEquals(self::TERM1_EN_DB, __(self::TERM1));
    }
}
