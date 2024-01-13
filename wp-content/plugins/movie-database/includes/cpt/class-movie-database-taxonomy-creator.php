<?php

class MVDB_Taxonomy_Creator
{
    private string $slug;
    private string $cpt;
    private array $labels;
    private string $description;
    private bool $public;
    private bool $has_archive;
    private array $rewrite;
    private bool $show_in_rest;
    private bool $show_ui;
    private bool $show_ui_in_menu;
    private bool $show_ui_in_nav_menus;
    private bool $show_ui_in_admin_bar;
    private string $menu_position;
    private bool $exclude_from_search;
    private bool $publicly_queryable;

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    public function setCPT(string $cpt): static
    {
        $this->cpt = $cpt;
        return $this;
    }

    public function setLabels(array $labels): static
    {
        $this->labels = $labels;
        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;
        return $this;
    }

    public function setHasArchive(bool $has_archive): static
    {
        $this->has_archive = $has_archive;
        return $this;
    }

    public function setRewrite(array $rewrite): static
    {
        $this->rewrite = $rewrite;
        return $this;
    }

    public function setShowInRest(bool $show_in_rest): static
    {
        $this->show_in_rest = $show_in_rest;
        return $this;
    }

    public function setShowUI(bool $show_ui): static
    {
        $this->show_ui = $show_ui;
        return $this;
    }

    public function setShowUIInMenu(bool $show_ui_in_menu): static
    {
        $this->show_ui_in_menu = $show_ui_in_menu;
        return $this;
    }

    public function setShowUIInNavMenus(bool $show_ui_in_nav_menus): static
    {
        $this->show_ui_in_nav_menus = $show_ui_in_nav_menus;
        return $this;
    }

    public function setShowUIInAdminBar(bool $show_ui_in_admin_bar): static
    {
        $this->show_ui_in_admin_bar = $show_ui_in_admin_bar;
        return $this;
    }

    public function setMenuPosition(string $menu_position): static
    {
        $this->menu_position = $menu_position;
        return $this;
    }

    public function setExcludeFromSearch(bool $exclude_from_search): static
    {
        $this->exclude_from_search = $exclude_from_search;
        return $this;
    }

    public function setPubliclyQueriable(bool $publicly_queriable): static
    {
        $this->publicly_queryable = $publicly_queriable;
        return $this;
    }

    public function register(): void
    {
        $args = $this->generateArgs();
        register_taxonomy($args['slug'], $args['cpt'], array_diff_key($args, ['slug', 'cpt']));
    }

    private function generateArgs(): array
    {
        foreach(get_object_vars($this) as $property_name => $value){
            if(!isset($value)) continue;
            $args[$property_name] = $value;
        }

        return $args ?? [];
    }
}