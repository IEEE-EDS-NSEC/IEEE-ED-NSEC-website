<?php
use Doctrine\DBAL\Schema\Comparator;
use Pastheme\Blog\Model\Category;
use Pastheme\Blog\Model\Post;
return [

    'install' => function ($app) {
        $util = $app['db']->getUtility();
        if ($util->tableExists('@dpnblog_post') === false) {
            $util->createTable('@dpnblog_post', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('slug', 'string', ['length' => 255]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('status', 'smallint');
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->addColumn('modified', 'datetime');
                $table->addColumn('content', 'text');
                $table->addColumn('comment_status', 'boolean', ['default' => false]);
                $table->addColumn('excerpt', 'text' , ['notnull' => false]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->addColumn('roles', 'simple_array', ['notnull' => false]);
                $table->addColumn('category_id', 'integer', ['notnull' => false]);
                $table->addColumn('tags', 'simple_array' , ['notnull' => false]);
                $table->addColumn('post_style', 'integer');
                $table->setPrimaryKey(['id']);
                $table->addIndex(['slug'], '@DPNBLOG_POST_SLUG');
                $table->addIndex(['title'], '@DPNBLOG_POST_TITLE');
                $table->addIndex(['user_id'], '@DPNBLOG_POST_USER_ID');
                $table->addIndex(['date'], '@DPNBLOG_POST_DATE');
                $table->addIndex(['post_style'], 'DPNBLOG_POST_POST_STYLE');
            });
        }

        if ($util->tableExists('@dpnblog_tags') === false) {
            $util->createTable('@dpnblog_tags' , function($table){
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('tags' , 'string' , ['length' => 100 , 'notnull' => false]);
                $table->addColumn('slug', 'string', ['length' => 255]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('date', 'datetime');
                $table->setPrimaryKey(['id']);
            });
        }

        if($util->tableExists('@dpnblog_category') === false){
            $util->createTable('@dpnblog_category' , function($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('slug', 'string', ['length' => 255]);
                $table->addColumn('status', 'string', ['length' => 255]);
                $table->addColumn('date', 'datetime');
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->setPrimaryKey(['id']);
            });
        }
    },

    'uninstall' => function ($app) {
        $util = $app['db']->getUtility();

        if ($util->tableExists('@dpnblog_post')) {
            $util->dropTable('@dpnblog_post');
        }

        if ($util->tableExists('@dpnblog_category')) {
            $util->dropTable('@dpnblog_category');
        }

        if ($util->tableExists('@dpnblog_tags')) {
            $util->dropTable('@dpnblog_tags');
        }

    },
    'enable' => function ($app) {

    },
    'disable' => function ($app) {},
    'updates' => [
        '2.0.1' => function ($app) {
            $util = $app['db']->getUtility();
			if ($util->tableExists('@dpnblog_post')) {
				$table =  $util->listTableDetails('@dpnblog_post');
				if (!$table->hasColumn('post_style')) {
					$table->addColumn('post_style', 'integer');
					$table->addIndex(['post_style'], 'DPNBLOG_POST_POST_STYLE');
					$util->alterTable((new Comparator())->diffTable($util->listTableDetails('@dpnblog_post'), $table));
					$app['db']->executeQuery('UPDATE @dpnblog_post SET status = 0');
				}
			}

            if ($util->tableExists('@dpnblog_category')) {
                $table = $util->listTableDetails('@dpnblog_category');
                if ($table->hasColumn('sub_category')) {
                    $table->dropColumn('sub_category');
                    $util->alterTable((new Comparator())->diffTable($util->listTableDetails('@dpnblog_category'), $table));
                }
            }

            if ($util->tableExists('@dpnblog_like')) {
                $util->dropTable('@dpnblog_like');
            }
        },
        '2.0.2' => function ($app) {

            $categories = Category::findAll();
            foreach ($categories as $category) {
                if ( !isset($category->data['meta']['og:title']) || !isset($category->data['meta']['og:description']) ) {
                    if ( !isset($category->data['meta']['og:title']) ) {
                        $category->data['meta']['og:title'] = "";
                    }
                    if ( !isset($category->data['meta']['og:description']) ) {
                        $category->data['meta']['og:description'] = "";
                    }
                    $category->save();
                }

            }
            $util = $app['db']->getUtility();
            if ($util->tableExists('@dpnblog_tags') === false) {
                $util->createTable('@dpnblog_tags' , function($table){
                    $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                    $table->addColumn('tags' , 'string' , ['length' => 100 , 'notnull' => false]);
                    $table->addColumn('slug', 'string', ['length' => 255]);
                    $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                    $table->addColumn('date', 'datetime');
                    $table->setPrimaryKey(['id']);
                });
            }

            if ($util->tableExists('@dpnblog_post')) {
                $posts = Post::findAll();
                foreach ($posts as $post) {
                    $post->tags = [];
                    $post->save();
                }
            }

        },

        '2.1.0' => function ($app) {
            $util = $app['db']->getUtility();
            if ($util->tableExists('@dpnblog_post')) {
                $table = $util->listTableDetails('@dpnblog_post');
                if (!$table->hasColumn('comment_status')) {
                    $table->addColumn('comment_status', 'boolean', ['default' => false]);
                    $util->alterTable((new Comparator())->diffTable($util->listTableDetails('@dpnblog_post'), $table));
                }
                if ($table->hasColumn('comment_count')) {
                    $table->dropColumn('comment_count');
                    $util->alterTable((new Comparator())->diffTable($util->listTableDetails('@dpnblog_post'), $table));
                }
            }
        }
    ]
];
?>
