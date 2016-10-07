<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push(trans('app.home'), route('home'));
});

// Home > [Play]
Breadcrumbs::register('play', function($breadcrumbs, $tournament)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($tournament->label, route('play', $tournament->id));
});

// Home > Login
Breadcrumbs::register('login', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('auth.login'), route('login'));
});

// Home > Register
Breadcrumbs::register('register', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('auth.register'), route('register'));
});