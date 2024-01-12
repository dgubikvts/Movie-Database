<?php

class MVDB_Deactivator
{
    public static function deactivate(): void
    {
        unregister_post_type('film');
        flush_rewrite_rules();
    }
}