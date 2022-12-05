<?php

namespace Tests\Unit;

use App\Http\Entities\RawSql;
use PHPUnit\Framework\TestCase;

class RawSqlTest extends TestCase
{
    public function test_get_date_time_string_by_type_should_return_empty_string()
    {
        $sut = new RawSql();

        $sut->setFilters();
        $result = $sut->getDateTimeStringByType('');

        $this->assertEquals('', $result);
    }

    public function test_get_date_time_string_by_type_should_return_date_time_string()
    {
        $sut = new RawSql();
        $dateStart = '2022-12-04 00:00:00';

        $sut->setFilters($dateStart);
        $result = $sut->getDateTimeStringByType('start');

        $this->assertEquals('2022-12-04 00:00:00', $result);
    }

    public function test_format_raw_sql_with_only_valid_id()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';

        $sut->setRawSql($rawSql);
        $result = $sut->formatRawSql();

        $this->assertEquals(
            'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id', 
            $result
        );
    }

    public function test_format_raw_sql_with_only_valid_date_start_and_date_end()
    {
        $sut = new RawSql();
        $dateStart = '2022-12-04 00:00:00';
        $dateEnd = '2022-12-05 00:00:00';
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';

        $sut->setRawSql($rawSql);
        $sut->setFilters($dateStart, $dateEnd);
        $result = $sut->formatRawSql();

        $this->assertEquals(
            'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at between ? and ?', 
            $result
        );
    }

    public function test_format_raw_sql_with_only_valid_date_end()
    {
        $sut = new RawSql();
        $dateEnd = '2022-12-05 00:00:00';
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';

        $sut->setRawSql($rawSql);
        $sut->setFilters('', $dateEnd);
        $result = $sut->formatRawSql();

        $this->assertEquals(
            'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at <= ?', 
            $result
        );
    }

    public function test_format_raw_sql_with_only_valid_date_start()
    {
        $sut = new RawSql();
        $dateStart = '2022-12-04 00:00:00';
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';

        $sut->setRawSql($rawSql);
        $sut->setFilters($dateStart);
        $result = $sut->formatRawSql();

        $this->assertEquals(
            'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at >= ?', 
            $result
        );
    }

    public function test_mount_bindings_with_no_optional_parameter()
    {
        $sut = new RawSql();
        
        $result = $sut->mountBindings();

        $this->assertEmpty($result);
    }

    public function test_mount_bindings_with_all_parameter()
    {
        $sut = new RawSql();
        $dateStart = '2022-12-04 00:00:00';
        $dateEnd = '2022-12-05 00:00:00';
        
        $sut->setFilters($dateStart, $dateEnd);
        $result = $sut->mountBindings();

        $this->assertEquals(['2022-12-04 00:00:00', '2022-12-05 00:00:00'], $result);
    }

    public function test_mount_bindings_with_date_start()
    {
        $sut = new RawSql();
        $dateStart = '2022-12-04 00:00:00';
        $sut->setFilters($dateStart);
        
        $result = $sut->mountBindings();

        $this->assertEquals(['2022-12-04 00:00:00'], $result);
    }

    public function test_mount_bindings_with_date_end()
    {
        $sut = new RawSql();
        $dateEnd = '2022-12-05 00:00:00';
        $sut->setFilters('', $dateEnd);
        
        $result = $sut->mountBindings();

        $this->assertEquals(['2022-12-05 00:00:00'], $result);
    }
}
