@php
    use app\view\components\Icon\Icon;
@endphp

@extends('layouts.admin.admin')

@section('content')

    <div class="main">

        <div class="page-name">
            Главная
        </div>

        <div class="container">

            <div class="block income">
                <div class="row">
                    <div class="column">
                        <div class="digit">1 545</div>

                        <div class="name">Прибыль</div>
                    </div>
                    <div class="icon"><?= Icon::income() ?></div>
                </div>

                <div class="row">
                    <canvas id="income" width="100" height="100"></canvas>
                </div>
            </div>


            <div class="block supplied">

                <div class="row">
                    <div class="column">
                        <div class="digit">245</div>
                        <div class="name">Отгружено</div>
                    </div>
                    <div class="icon"><?= Icon::shipped() ?></div>
                </div>

                <div class="row">
                    <canvas id="supplied" width="100" height="100"></canvas>
                </div>

            </div>


            <div class="block newCustomers">

                <div class="row">
                    <div class="column">
                        <div class="digit">4</div>
                        <div class="name">Новых клиентов</div>
                    </div>
                    <div class="icon"><?= Icon::cart() ?></div>
                </div>

                <div class="row">
                    <canvas id="newCustomers" width="100" height="100"></canvas>
                </div>

            </div>

            <div class="block coefficient">

                <div class="row">
                    <div class="column">
                        <div class="digit">78</div>
                        <div class="name">Коэффициент</div>
                    </div>
                    <div class="icon"><?= Icon::coefficient() ?></div>
                </div>

                <div class="row">
                    <canvas id="coefficient" width="100" height="100"></canvas>
                </div>

            </div>


        </div>

        <div class="container">

            <div class="block xl-1">

                <ul class="user-actions">
                    <? if (defined('SU')): ?>
                    <li class="user-action">
                        <a href="/adminsc/sync">1s Sync</a>
                    </li>

                    <? endif; ?>

                </ul>
            </div>
        </div>
    </div>
@endsection
