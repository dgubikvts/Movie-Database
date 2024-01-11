<?php

class MVDB_i18n
{
    public function mvdb_load_textdomain(): void
    {
        load_plugin_textdomain('movie-database', false, MVDB_PLUGIN . 'languages/');
    }
}