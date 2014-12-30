<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VersionAndRevisionTalks extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talk_versions', function(Blueprint $table)
        {
            $table->string('id', 36)->unique();
            $table->string('nickname', 150);
            $table->string('type', 50);

            $table->timestamps();

            $table->string('talk_id', 36);
            $table->foreign('talk_id')
                ->references('id')
                ->on('talks')
                ->onDelete('cascade');

            /*
             * - uuid
             * - nickname (?)
             * - type (keynote, talk, tutorial, lightning)
             * - FK talk_id
             */
        });

        Schema::create('talk_version_revisions', function(Blueprint $table)
        {
            $table->string('id', 36)->unique();
            $table->string('title', 255);
            $table->text('description');
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->integer('length');
            $table->text('outline');
            $table->text('organizer_notes');

            $table->timestamps();

            $table->string('talk_version_id', 36);
            $table->foreign('talk_version_id')
                ->references('id')
                ->on('talk_versions')
                ->onDelete('cascade');
            /*
                - uuid
                - title
                - description
                - level (beginner, intermediate, advanced)
                - Length
                - outline
                - organizer notes
                - links to previous feedback pages (? is this attached to version or revision?)
                - links to previous slide decks (? is this attached to version or revision?)
                - links to previous video links (? is this attached to version or revision?)
                - FK talk_version_id
                - timestamps
             */
        });

        Schema::table('talks', function(Blueprint $table) {
            $table->dropColumn('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('talk_versions');

        Schema::drop('talk_version_revisions');

        Schema::table('talks', function(Blueprint $table) {
            $table->text('body');
        });
    }

}
