<?php
think\Route::get("/","index/index/index");
think\Route::get(":title","index/common/index");
think\Route::get("/address/:title","index/index/index");

think\Route::get("/navs/:title","index/common/index");
think\Route::get("/show/:title/:id","index/common/show");
think\Route::post("/form/:id","index/form/form");
think\Route::get("/search/","index/search/index");

$route = db("nav")->select();
foreach ($route as $k=>$v){
    think\Route::get("{$v['url_static']}/:id","index/common/show");
}

                    