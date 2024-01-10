<?php

namespace Itrvb\galimova\Blog\Http\Actions;

use Itrvb\galimova\Blog\Http\Request;
use Itrvb\galimova\Blog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}