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

    public function test_check_if_raw_sql_parameters_are_correct_should_return_null_without_sql_and_inputed_parameters()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';

        $sut->setRawSql($rawSql);
        $result = $sut->checkIfRawSqlParametersAreCorrect();

        $this->assertNull($result);
    }

    public function test_check_if_raw_sql_parameters_are_correct_should_throw_exception_with_sql_dateStart_present_and_no_inputed_dateStart()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at > dateStart';

        $sut->setRawSql($rawSql);

        $this->expectExceptionMessage('The report query has a dateStart parameter but it was not given a valid value');
        $sut->checkIfRawSqlParametersAreCorrect();
    }

    public function test_check_if_raw_sql_parameters_are_correct_should_throw_exception_with_sql_dateEnd_present_and_no_inputed_dateEnd()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at < dateEnd';

        $sut->setRawSql($rawSql);

        $this->expectExceptionMessage('The report query has a dateEnd parameter but it was not given a valid value');
        $sut->checkIfRawSqlParametersAreCorrect();
    }

    public function test_check_if_raw_sql_parameters_are_correct_should_throw_exception_with_sql_dateEnd_and_dateStart_present_and_no_inputed_parameter()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at between dateStart and dateEnd';

        $sut->setRawSql($rawSql);

        $this->expectExceptionMessage('The report query has a dateStart parameter but it was not given a valid value');
        $sut->checkIfRawSqlParametersAreCorrect();
    }

    public function test_raw_sql_has_date_start_parameter_should_return_true_with_sql_contains_date_start()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at > dateStart';

        $sut->setRawSql($rawSql);
        $result = $sut->rawSqlHasDateStartParameter();

        $this->assertTrue($result);
    }

    public function test_raw_sql_has_date_start_parameter_should_return_true_with_sql_contains_date_end()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at > dateEnd';

        $sut->setRawSql($rawSql);
        $result = $sut->rawSqlHasDateEndParameter();

        $this->assertTrue($result);
    }

    public function test_raw_sql_has_date_start_parameter_should_return_false_with_sql_doenst_contains_date_start()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at';

        $sut->setRawSql($rawSql);
        $result = $sut->rawSqlHasDateStartParameter();

        $this->assertFalse($result);
    }

    public function test_raw_sql_has_date_start_parameter_should_return_true_with_sql_doesnt_contains_date_end()
    {
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at';

        $sut->setRawSql($rawSql);
        $result = $sut->rawSqlHasDateEndParameter();

        $this->assertFalse($result);
    }

    public function test_format_raw_sql_should_return_correct_bidings_and_sql_with_date_start_and_date_end()
    {   
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at between dateStart and dateEnd';
        $dateStart = '2022-12-04 00:00:00';
        $dateEnd = '2022-12-04 00:00:00';

        $sut->setRawSql($rawSql);
        $sut->setFilters($dateStart, $dateEnd);

        $result = $sut->formatRawSql();

        $expectedFormatedSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at between ? and ?';
        $expectedBindings = ['2022-12-04 00:00:00', '2022-12-04 00:00:00'];

        $this->assertIsObject($result);
        $this->assertObjectHasAttribute('formatedSql', $result);
        $this->assertObjectHasAttribute('bindings', $result);
        $this->assertEquals($expectedFormatedSql, $result->formatedSql);
        $this->assertEquals($expectedBindings, $result->bindings);
    }

    public function test_format_raw_sql_should_return_empty_bidings_and_sql_without_date_start_and_date_end()
    {   
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';

        $sut->setRawSql($rawSql);

        $result = $sut->formatRawSql();

        $expectedFormatedSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id';
        $expectedBindings = [];

        $this->assertIsObject($result);
        $this->assertObjectHasAttribute('formatedSql', $result);
        $this->assertObjectHasAttribute('bindings', $result);
        $this->assertEquals($expectedFormatedSql, $result->formatedSql);
        $this->assertEquals($expectedBindings, $result->bindings);
    }

    public function test_format_raw_sql_should_return_correct_bidings_and_sql_with_date_start()
    {   
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at > dateStart';
        $dateStart = '2022-12-04 00:00:00';

        $sut->setRawSql($rawSql);
        $sut->setFilters($dateStart);

        $result = $sut->formatRawSql();

        $expectedFormatedSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at > ?';
        $expectedBindings = ['2022-12-04 00:00:00'];

        $this->assertIsObject($result);
        $this->assertObjectHasAttribute('formatedSql', $result);
        $this->assertObjectHasAttribute('bindings', $result);
        $this->assertEquals($expectedFormatedSql, $result->formatedSql);
        $this->assertEquals($expectedBindings, $result->bindings);
    }

    public function test_format_raw_sql_should_return_correct_bidings_and_sql_with_date_end()
    {   
        $sut = new RawSql();
        $rawSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at < dateEnd';
        $dateEnd = '2022-12-04 00:00:00';

        $sut->setRawSql($rawSql);
        $sut->setFilters(null, $dateEnd);

        $result = $sut->formatRawSql();

        $expectedFormatedSql = 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at < ?';
        $expectedBindings = ['2022-12-04 00:00:00'];

        $this->assertIsObject($result);
        $this->assertObjectHasAttribute('formatedSql', $result);
        $this->assertObjectHasAttribute('bindings', $result);
        $this->assertEquals($expectedFormatedSql, $result->formatedSql);
        $this->assertEquals($expectedBindings, $result->bindings);
    }
}
