<?php

class MVDB_Activator
{
    public static function activate(): void
    {
        flush_rewrite_rules();
    }
}