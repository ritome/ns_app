@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('育成プログラム表') }}
    </h2>
@endsection

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
                                <!-- 1週目〜2週目 -->
                                <tr>
                                    <td rowspan="2" class="border border-gray-300 px-2 py-2 text-sm align-top">
                                        1週目<br>〜<br>2週目
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2 relative">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-1 h-full bg-gray-400 absolute left-0 top-0"></div>
                                            <span class="text-sm ml-3">西棟日勤業務</span>
                                        </div>
                                    </td>
                                    <td rowspan="2" class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>食事介助</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>水分補給</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>経管栄養</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>胃瘻・腸瘻</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>排泄ケア</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>バギー操作</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>移乗</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>処置</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>与薬</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>吸入</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td rowspan="2" class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>西棟日勤業務流れ</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>西棟日勤業務流れ（入浴）</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>たんぽ業務</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>内服マニュアル</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>看護手順</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>医療安全マニュアル</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>感染対策マニュアル</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="mb-4 text-sm">
                                            <h4 class="font-bold mb-2">西棟</h4>
                                            <div class="space-y-1">
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>メンバー業務が理解できる</span>
                                                </div>
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>支援を受けてメンバー業務を遂行できる</span>
                                                </div>
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>利用者個々の顔・名前が一致し特性を理解できる</span>
                                                </div>
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>痙攣発作等の症状アセスメント及び対処ができる</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 text-sm">
                                            <h4 class="font-bold mb-2">東棟</h4>
                                            <div class="space-y-1">
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>メンバー業務が理解できる</span>
                                                </div>
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>支援を受けてメンバー業務を遂行できる</span>
                                                </div>
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>利用者個々の顔・名前が一致し特性を理解できる</span>
                                                </div>
                                                <div class="flex items-start">
                                                    <input type="checkbox" class="mt-1 mr-2">
                                                    <span>痙攣発作等の症状アセスメント及び対処ができる</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-2 py-2 relative">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-1 h-full bg-gray-400 absolute left-0 top-0"></div>
                                            <span class="text-sm ml-3">東棟日勤業務</span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 2〜3ヶ月頃 -->
                                <tr>
                                    <td class="border border-gray-300 px-2 py-2 text-sm">
                                        2〜3<br>ヶ月頃
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2 relative">
                                        <div class="space-y-4">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-1 h-full bg-gray-400 absolute left-0 top-0"></div>
                                                <span class="text-sm ml-3">西棟・早日勤業務</span>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <span class="text-sm ml-3">西棟遅番業務</span>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <span class="text-sm ml-3">西棟リーダー業務</span>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <span class="text-sm ml-3">東棟リーダー業務</span>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <span class="text-sm ml-3">西棟夜勤業務</span>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <span class="text-sm ml-3">東棟夜勤業務</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>スマートベスト</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>採血・培養</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>入浴介助</span>
                                            </div>
                                            <div class="flex items-start pl-8">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>洗体</span>
                                            </div>
                                            <div class="flex items-start pl-8">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>処置</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>通院介助</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>耳鼻科診</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>整形外科診</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>休日日勤会</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>定期薬作成</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>夜勤業務（西棟）</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>夜勤業務（たんぽ）</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>看護マニュアル</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>緊急時・急変時対応を理解し遂行できる</span>
                                            </div>
                                            <h4 class="font-bold mt-4 mb-2">西棟</h4>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>早日勤業務を理解し遂行できる</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>遅番業務を理解し遂行できる（多職種評価あり）</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>リーダー業務を理解し遂行できる</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>リーダーシップをとることができる</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>夜勤業務を理解し遂行できる（多職種評価あり）</span>
                                            </div>
                                            <h4 class="font-bold mt-4 mb-2">東棟</h4>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>リーダー業務を理解し遂行できる</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>リーダーシップをとることができる</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 〜4ヶ月目 -->
                                <tr>
                                    <td class="border border-gray-300 px-2 py-2 text-sm">
                                        〜4<br>ヶ月目
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2 relative">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-1 h-full bg-gray-400 absolute left-0 top-0"></div>
                                            <span class="text-sm ml-3">変則勤務</span>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2"></td>
                                    <td class="border border-gray-300 px-2 py-2"></td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>個別学びリストを概ね網羅できる</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 5ヶ月目以降 -->
                                <tr>
                                    <td class="border border-gray-300 px-2 py-2 text-sm">
                                        5ヶ月目<br>以降
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2 relative">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-1 h-full bg-gray-400 absolute left-0 top-0"></div>
                                            <span class="text-sm ml-3">変則勤務</span>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>個別支援計画</span>
                                            </div>
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>モニタリングカンファレンス参加</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2"></td>
                                    <td class="border border-gray-300 px-2 py-2">
                                        <div class="space-y-1 text-sm">
                                            <div class="flex items-start">
                                                <input type="checkbox" class="mt-1 mr-2">
                                                <span>パートナーの受け持ち利用者の個別支援計画の評価やモニタリングカンファレンスに参画できる。</span>
                                            </div>
                                            <div class="flex items-start mt-2">
                                                <span class="text-sm">*次年度以降の受け持ちに際し経験しておく</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
