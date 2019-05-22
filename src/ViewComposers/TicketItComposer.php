<?php

namespace Kordy\Ticketit\ViewComposers;

use Kordy\Ticketit\Controllers\ToolsController;
use Kordy\Ticketit\Helpers\EditorLocale;
use Kordy\Ticketit\Models\Agent;
use Kordy\Ticketit\Models\TSetting;
use Sentinel;

class TicketItComposer
{
    public static function settings(&$u)
    {
        view()->composer('ticketit::*', function ($view) use (&$u) {
            if (Sentinel::check()) {
                if ($u === null) {
                    $u = Agent::find(Sentinel::getUser()->id);
                }
                $view->with('u', $u);
            }
            
            $setting = new TSetting();
            $view->with('setting', $setting);
        });
    }

    public static function general()
    {
        // Passing to views the master view value from the setting file
        view()->composer('ticketit::*', function ($view) {

            $tools = new ToolsController();
            $master = TSetting::grab('master_template');
            $email = TSetting::grab('email.template');
            $view->with(compact('master', 'email', 'tools'));
        });
    }

    public static function codeMirror()
    {
        // Passing to views the master view value from the setting file
        view()->composer('ticketit::*', function ($view) {
            $editor_enabled = TSetting::grab('editor_enabled');
            $codemirror_enabled = TSetting::grab('editor_html_highlighter');
            $codemirror_theme = TSetting::grab('codemirror_theme');
            $view->with(compact('editor_enabled', 'codemirror_enabled', 'codemirror_theme'));
        });
    }

    public static function summerNotes()
    {
        view()->composer('ticketit::tickets.partials.summernote', function ($view) {

            $editor_locale = EditorLocale::getEditorLocale();
            $editor_options = file_get_contents(base_path(TSetting::grab('summernote_options_json_file')));

            $view->with(compact('editor_locale', 'editor_options'));
        });
    }

    public static function sharedAssets()
    {
        //inlude font awesome css or not
        view()->composer('ticketit::shared.assets', function ($view) {
            $include_font_awesome = TSetting::grab('include_font_awesome');
            $view->with(compact('include_font_awesome'));
        });
    }
}