@extends('layouts.admin.admin')

@section('content')

    <div class="category-tree">
        <ul>
            <?= $categoryTree; ?>
        </ul>
    </div>

@endsection


