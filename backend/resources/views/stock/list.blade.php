<x-app-layout>
    @section('title', '在庫一覧')
    <x-slot name="header">
        @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
        管理者用　在庫一覧
        @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
        在庫一覧
        @elsecan('guest') {{-- ゲストに表示される --}}
        ゲスト用　在庫一覧
        @endcan
    </x-slot>

    <div class="py-24 -mt-20 sm:flex justify-center md:py-32 lg:py-40 xl:-mt-32">
        <div class="flex justify-center">
            @can('admin-higher') {{-- 管理者権限以上に表示される --}}
            <div class="flex justify-center md:-mt-6">
                <form method="post" action="/admin/list/search" class="-mb-2 form-inline m-5">
                    @csrf
                    <input type="text" name="search" value="{{$keyword}}" placeholder="在庫を検索" class="bg-gray-100 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300">
                    <button class="font-semibold bg-blue-600 text-white hover:opacity-75 py-2 px-4 rounded">
                        検索
                    </button>
                </form>
            </div>
            @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
            <div class="sm:flex justify-center mt-5 md:-mt-6 md:mr-20 lg:mr-12">
                <a href="/list/add" class="font-semibold ml-32 py-2 px-4 h-10 bg-blue-600 text-white hover:opacity-75 rounded
                                md:mt-10">
                    追加</a>
                <form method="post" action="/list/search" class="form-inline m-5">
                    @csrf
                    <input type="text" name="search" value="{{$keyword}}" placeholder="在庫を検索" class="mt-5 bg-gray-100 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300">
                    <button class="font-semibold bg-blue-600 text-white hover:opacity-75 py-2 px-4 rounded">
                        検索
                    </button>
                </form>
            </div>
            @elsecan('guest') {{-- ゲストに表示される --}}
            <div class="sm:flex justify-center mt-5 md:-mt-6 md:mr-20 lg:mr-12 xl:-ml-12">
                <a href="/guest/list/add" class="font-semibold ml-32 py-2 px-4 h-10 bg-blue-600 text-white hover:opacity-75 rounded
                                md:mt-10">
                    追加
                </a>
                <form method="post" action="/guest/list/search" class="form-inline m-5">
                    @csrf
                    <input type="text" name="search" value="{{$keyword}}" placeholder="在庫を検索" class="mt-5 bg-gray-100 hover:bg-white hover:border-gray-300 focus:outline-none focus:bg-white focus:shadow-outline focus:border-gray-300">
                    <button class="font-semibold bg-blue-600 text-white hover:opacity-75 py-2 px-4 rounded">
                        検索
                    </button>
                </form>
            </div>
            @endcan
        </div>
    </div>

    @if (isset($err))
    <div class="flex justify-center mb-12 lg:-mt-10">
        <p>{{$err}}</p>
    </div>
    @endif

    @if (isset($stocks) && !isset($err))
    <div class="max-h-screen flex items-center px-4 -mt-20 md:-mt-24 lg:-mt-32 xl:-mt-40">
        <div class='overflow-x-auto w-full'>
            @if (isset($count) && $count === 0 && !isset($err) && isset($keyword))
            <div class="flex justify-center my-12">
                <p class="-mt-12 xl:mt-1 xl:mb-4">該当商品がありません。</p>
            </div>
            @endif
            <table class='mx-auto max-w-4xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                <thead class="bg-gray-600">
                    <tr>
                        @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            在庫名
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            ユーザーID
                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            期限
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            商品
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            数量
                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        @elsecan('guest') {{-- ゲストに表示される --}}
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            期限
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            商品
                        </th>
                        <th class="font-semibold text-lg text-white px-6 py-4 text-center">
                            数量
                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        <th class="font-semibold text-lg px-6 py-4">

                        </th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($stocks as $stock)
                    <tr class="text-center">
                        @can('admin-higher')　{{-- 管理者権限以上に表示される --}}
                        <td class="text-lg px-6 py-4">
                            <p class="">
                                {{$stock->name}}
                            </p>
                        </td>
                        <td>
                            <p class="text-lg px-6 py-4">
                                {{$stock->user_id}}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/admin/list/show/{{$stock->id}}" class="font-semibold text-lg bg-blue-600 text-white py-1 px-4 hover:opacity-75 rounded">詳細</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/admin/list/delCheck/{{$stock->id}}" class="font-semibold text-lg bg-red-600 text-white py-1 px-4 hover:opacity-75 rounded">削除</a>
                        </td>
                        @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
                        <td class="text-lg px-6 py-4r">
                            <p class="space-x-3">
                                {{$stock->deadline}}
                            </p>
                        </td>
                        <td class="text-lg px-6 py-4">
                            <p class="">
                                {{$stock->name}}
                            </p>
                        </td>
                        <td>
                            <p class="text-lg px-6 py-4">
                                {{$stock->number}}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/list/show/{{$stock->id}}" class="font-semibold text-lg bg-blue-600 text-white py-1 px-4 hover:opacity-75 rounded">詳細</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/list/edit/{{$stock->id}}" class="font-semibold text-lg bg-blue-600 text-white py-1 px-4 hover:opacity-75 rounded">編集</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/list/delCheck/{{$stock->id}}" class="font-semibold text-lg bg-red-600 text-white py-1 px-4 hover:opacity-75 rounded">削除</a>
                        </td>
                        @elsecan('guest') {{-- ゲストに表示される --}}
                        <td class="text-lg px-6 py-4r">
                            <p class="space-x-3">
                                {{$stock->deadline}}
                            </p>
                        </td>
                        <td class="text-lg px-6 py-4">
                            <p class="">
                                {{$stock->name}}
                            </p>
                        </td>
                        <td>
                            <p class="text-lg px-6 py-4">
                                {{$stock->number}}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/guest/list/show/{{$stock->id}}" class="font-semibold text-lg bg-blue-600 text-white py-1 px-4 hover:opacity-75 rounded">詳細</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/guest/list/edit/{{$stock->id}}" class="font-semibold text-lg bg-blue-600 text-white py-1 px-4 hover:opacity-75 rounded">編集</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="/guest/list/delCheck/{{$stock->id}}" class="font-semibold text-lg bg-red-600 text-white py-1 px-4 hover:opacity-75 rounded">削除</a>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="py-10 flex justify-center">
        {{ $stocks->links() }}
    </div>
    @endif

    @if (isset($err) || isset($count) && $count === 0 && !isset($err) && isset($keyword))
    <div class="flex justify-center py-12">
        @can('admin-higher') {{-- 一般権限以上に表示される --}}
        <a href="/admin/list" class="w-24 py-2 border-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded">
            戻る</a>
        @elsecan('user-higher') {{-- 一般権限以上に表示される --}}
        <a href="/list" class="w-24 py-2 border-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded">
            戻る</a>
        @elsecan('guest') {{-- ゲストに表示される --}}
        <a href="/guest/list" class="w-24 py-2 border-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded">
            戻る</a>
        @endcan
    </div>
    @endif
</x-app-layout>
