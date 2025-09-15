@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl font-bold mb-6 text-center">みちのく療育園メディカルセンター 看護部看護課 新人看護職員育成プログラム</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300 table-fixed">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-2 py-2 w-24 text-sm">目安</th>
                                    <th class="border border-gray-300 px-2 py-2 w-40 text-sm">業務</th>
                                    <th class="border border-gray-300 px-2 py-2 w-64 text-sm">必須経験事項</th>
                                    <th class="border border-gray-300 px-2 py-2 w-64 text-sm">習得支援</th>
                                    <th class="border border-gray-300 px-2 py-2 text-sm">到達目標（評価指標）</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('program-schedule.partials._week1-2')
                                @include('program-schedule.partials._month2-3')
                                @include('program-schedule.partials._month4-5')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .py-12 {
                padding: 0;
            }

            .shadow-sm {
                box-shadow: none;
            }

            .bg-gray-100 {
                background-color: #f3f4f6 !important;
            }

            @page {
                size: landscape;
            }
        }
    </style>
@endsection

