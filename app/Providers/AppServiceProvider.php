<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Html::macro('formmodal', function($modalId, $modalName, $route ,$formId, $include, $edit = false){
            $idField = "";
            $included = \View::make($include);;
            if($edit){
                $idField = \Form::hidden('id');
            }

            return '<div class="modal container fade" id="'.$modalId.'" tabindex="-1" role="basic" aria-hidden="true"><div class=""><div class=""><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">'.$modalName.'</h4></div>'.\Form::open(array('route' => $route, 'id' => $formId)).'<div class="modal-body">'.$idField.'<div class="form-body">'.$included.'</div><div class="modal-footer"><button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button><button type="submit" class="btn green">Kaydet</button></div>'.\Form::close() .'</div></div></div></div>';
        });

        \Html::macro('deletemodal', function($modalId, $route ,$formId, $recordName){
            return '<div class="modal fade" id="'.$modalId.'" tabindex="-1" role="basic" aria-hidden="true"><div class=""><div class=""><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">Kaydı Sil</h4></div>'.\Form::open(array("route" => $route, 'id' => $formId)) .'<div class="modal-body">'. \Form::hidden('id') .'<div class="form-body">Bu kaydı silmek istediğinize emin misiniz? <br><br><input class="noBorderInput" type="text" style="width:100%;" name="'.$recordName.'" readonly><br><br></div><div class="modal-footer"><button type="button" class="btn dark btn-outline" data-dismiss="modal">Kapat</button><button type="submit" class="btn red">Sil</button></div>'.\Form::close() .'</div></div></div></div>';
        });

        \Html::macro('back', function(){
            return '<a href="'. \URL::previous() .'" type="button" class="btn default"><i class="fa fa-long-arrow-left"></i> Go Back</a>';
        });

        \Html::macro('pagetitle', function($header, $span = null){
            return '<h3 class="page-title">'.$header.' <small>'.$span.'</small></h3>';
        });
        
        \Html::macro('breadcrumb', function($page1, $link1 = null, $page2 = null, $link2 = null, $page3 = null, $link3 = null) {
            $level1 = "";
            $level2 = "";
            $level3 = "";
            if($page1 != null){
                if($link1 == null){
                    $level1 = '<li><span>'.$page1.'</span></li>';
                }else{
                    $level1 = '<li><a href="'.route($link1).'">'.$page1.'</a><i class="fa fa-circle"></i></li>';
                }
            }
            if($page2 != null){
                if($link2 == null){
                    $level2 = '<li><span>'.$page2.'</span></li>';
                }else{
                    $level2 = '<li><a href="'.route($link2).'">'.$page2.'</a><i class="fa fa-circle"></i></li>';
                }
            }
            if($page3 != null){
                if($link3 == null){
                    $level3 = '<li><span>'.$page3.'</span></li>';
                }else{
                    $level3 = '<li><a href="'.route($link3).'">'.$page3.'</a><i class="fa fa-circle"></i></li>';
                }
            }  
            return '<div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="'.route('home').'">Anasayfa</a>
                        <i class="fa fa-circle"></i>
                    </li>'.$level1.$level2.$level3.'
                </ul>
            </div>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', function ($view) {
            if(\Request::route()){
                $currentRouteName = \Request::route()->getName();
            }else{
                $currentRouteName = "";
            }
            $view->with('currentRouteName', $currentRouteName);
        });
    }
}
