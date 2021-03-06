<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableJiraIssuesAddColumnStatusId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jira_issues', function (Blueprint $table) {
            $table->integer('assignee_id')->comment('Id исполнителя (jira_users)');
            $table->integer('status_id')->comment('Текущий статус');
            $table->integer('previous_status_id')->comment('Предыдущий статус');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jira_issues', function (Blueprint $table) {
            $table->dropColumn('assignee_id');
            $table->dropColumn('status_id');
            $table->dropColumn('previous_status_id');
        });
    }
}
