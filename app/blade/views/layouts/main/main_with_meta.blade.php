@extends('layouts.main.main')
@deb
@section('title', $meta['seo_title']??$meta["title"])
@section('description', $meta['seo_desc']??$meta["description"])
@section('keywords', $meta['seo_keywords']??$meta["keywords"])