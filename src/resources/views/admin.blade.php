@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('show_nav')
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">logout</button>
    </form>
@endsection

@section('content')
    <div class="admin__content">
        <div class="admin__heading">
            <h2>Admin</h2>
        </div>
        <form action="{{ route('admin') }}" method="get" class="admin__search-form">
            <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ $keyword ?? '' }}">
            <div class="form__input-select">
                <select name="gender">
                    <option value="">性別</option>
                    <option value="1" {{ isset($gender) && $gender == 1 ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ isset($gender) && $gender == 2 ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ isset($gender) && $gender == 3 ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="form__input-select">
                <select name="category_id">
                    <option value="">お問い合わせの種類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($category_id) && $category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form__input-date">
                <input type="date" name="date" value="{{ $date ?? '' }}">
            </div>
            <button class="search__button" type="submit">検索</button>
            <a href="{{ route('admin') }}" class="reset__button">リセット</a>
        </form>

        <div class="flex">
            <div class="export-button">
                <a href="{{ route('admin.export', request()->query()) }}" class="export__button-submit">エクスポート</a>
            </div>
            <div class="pagination">
                {{ $contacts->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="table">
            <table class="admin-table">
                <tr class="admin-table__row">
                    <th class="admin-table__header">お名前</th>
                    <th class="admin-table__header">性別</th>
                    <th class="admin-table__header">メールアドレス</th>
                    <th class="admin-table__header">お問い合わせの種類</th>
                    <th class="admin-table__header"></th>
                </tr>
                @foreach ($contacts as $contact)
                    <tr class="admin-table__row">
                        <td class="admin-table__text">
                            {{ $contact->last_name }} {{ $contact->first_name }}
                        </td>
                        <td class="admin-table__text">
                            @if ($contact->gender == 1)
                                男性
                            @elseif ($contact->gender == 2)
                                女性
                            @else
                                その他
                            @endif
                        </td>
                        <td class="admin-table__text">{{ $contact->email }}</td>
                        <td class="admin-table__text">{{ $contact->category->content ?? '' }}</td>
                        <td class="admin-table__text">
                            <a href="#modal{{ $contact->id }}" class="detail__button">詳細</a>

                            <div id="modal{{ $contact->id }}" class="modal">
                                <div class="modal-content">
                                    <table class="modal-table">
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">お名前</th>
                                            <td class="modal-table__text">{{ $contact->last_name }}
                                                {{ $contact->first_name }}
                                            </td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">性別</th>
                                            <td class="modal-table__text">
                                                @if ($contact->gender == 1)
                                                    男性
                                                @elseif ($contact->gender == 2)
                                                    女性
                                                @else
                                                    その他
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">メールアドレス</th>
                                            <td class="modal-table__text">{{ $contact->email }}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">電話番号</th>
                                            <td class="modal-table__text">{{ $contact->tel }}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">住所</th>
                                            <td class="modal-table__text">{{ $contact->address }}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">建物名</th>
                                            <td class="modal-table__text">{{ $contact->building }}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">お問い合わせ種類</th>
                                            <td class="modal-table__text">{{ $contact->category->content ?? '' }}</td>
                                        </tr>
                                        <tr class="modal-table__row">
                                            <th class="modal-table__header">お問い合わせ内容</th>
                                            <td class="modal-table__text">{{ $contact->detail }}</td>
                                        </tr>
                                    </table>

                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="delete-form__button">
                                            <input type="hidden" name="id" value="{{ $contact['id'] }}">
                                            <button class="delete-form__button-submit" type="submit">削除</button>
                                        </div>
                                    </form>
                                    <a href="#" class="modal__close">✕</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
