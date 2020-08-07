@extends('layouts.admin')

@section('styles')

@endsection

@section('content')
    <?php $imagePath = asset('images') ?>
    <?php $imagesServe = asset('imagesServe') ?>
    <!-- BEGIN PAGE HEADER-->

    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered calendar">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">{{ isset($title) ? $title : 'Admin panel' }}</span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">

                            <?php $user = \App\User::findOrFail(Auth::user()->id); ?>

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <th>{{ $properties['native'] }}</th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($articles as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>

                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <?php $trans = $article->trans($localeCode)->first() ?>
                                            @if($trans)
                                                <td>{{ $trans->title }}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                        <td><a class="btn btn-primary" href="{{ route('admin.advertiserCompanies.show', ['id' => $article->id]) }}"><i class="fa fa-file" data-toggle="tooltip" data-placement="left" title="Edit"></i></a></td>
                                        @if($user->bookmarkedAdvertComp()->where(['advert_comp_id' => $article->id])->first())
                                            <td><a class="btn btn-primary" href="{{ route('admin.bookmarked.deleteAdvertiserCompaniesBookmarked', ['id' => $article->id]) }}"><i class="far fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a></td>
                                        @else
                                            <td><a class="btn btn-primary" href="{{ route('admin.bookmarked.addAdvertiserCompaniesBookmark', ['id' => $article->id]) }}"><i class="fas fa-bookmark" data-toggle="tooltip" data-placement="left" title=""></i></a></td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{--Pagination--}}
                            <nav  aria-label="Page navigation">
                                <ul class="pagination">
                                    @if(isset($articles))
                                        @if($articles->lastPage() > 1)

                                            @if($articles->currentPage() !== 1)
                                                <li class="disabled">
                                                    <a aria-label="Previous" href="{{ $articles->url(($articles->currentPage() - 1)) }}">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @for($i = 1; $i <= $articles->lastPage(); $i++)
                                                @if($articles->currentPage() == $i)
                                                    <li class="active">
                                                        <a class="disabled">{{ $i }}</a>

                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ $articles->url($i) }}">{{ $i }}</a>

                                                    </li>
                                                @endif
                                            @endfor

                                            @if($articles->currentPage() !== $articles->lastPage())
                                                <li>
                                                    <a aria-label="Next" href="{{ $articles->url(($articles->currentPage() + 1)) }}">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif

                                    @endif
                                </ul>
                            </nav>{{--Pagination end--}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function()
        {
            $('#clickmewow').click(function()
            {
                $('#radio1003').attr('checked', 'checked');
            });

            $('.deleteSubmit').on('click', function () {
                $(this).closest('td').find('form').submit();
            });
        })
    </script>

@endsection