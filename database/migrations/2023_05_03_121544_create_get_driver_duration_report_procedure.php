<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGetDriverDurationReportProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable(!'get_driver_duration_report')) {

        DB::unprepared("
            CREATE PROCEDURE `get_driver_duration_report`(IN date1 date, IN date2 date, IN dr_id int)
            BEGIN
                -- Declare data_exits int;
                set @data_exists = (SELECT count(driver_id) FROM driver_availabilities where created_at between date1 and date2 and driver_id = dr_id);
                
                if(@data_exists > 0) then
                    select A.selected_date, dr_id, case when B.duration > 0 then B.duration
                    else '-' end duration from ( select selected_date from
                    (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
                     (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                     (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                     (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                     (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                     (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                    where selected_date between  date1 and date2) A
                    left join (SELECT driver_id, sum(duration) as duration, date(created_at) as date FROM driver_availabilities where driver_id = driver_id and created_at between date1 and date2 group by date, driver_id) B on B.date = A.selected_date
                    group by B.driver_id,A.selected_date,B.duration order by selected_date;
                else
                    select 0;
                end if;
            END
        ");
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_driver_duration_report");
 
    }
}
