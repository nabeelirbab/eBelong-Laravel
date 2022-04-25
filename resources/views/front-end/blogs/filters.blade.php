<aside id="wt-sidebar" class="wt-sidebar">
    {!! Form::open(['url' => url('search-results'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch wt-formbackground']) !!}
        <input type="hidden" value="{{$type}}" name="type">
        <!-- <div class="wt-widget wt-effectiveholder wt-startsearch" style="padding-bottom: 0px; margin: 0px; ">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.start_search') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                 <span><i class="fas fa-th"></i></span>
                <span><i class="fas fa-list"></i></span>
            </div>
        </div> -->
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.cats') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_cat') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($categories))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($categories as $category)
                                @php $checked = ( !empty($_GET['category']) && in_array($category->slug, $_GET['category'] )) ? 'checked' : ''; @endphp
                                <span class="wt-checkbox">
                                    <input id="cat-{{{ $category->slug }}}" type="checkbox" name="category[]" value="{{{ $category->slug }}}" {{$checked}} >
                                    <label for="cat-{{{ $category->slug }}}"> <a href="{{ url('blogs/'.$category->slug) }}"  >{{{ $category->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
                <div class="wt-widget wt-effectiveholder">
                    <div class="wt-widgettitle">
                        <h2>{{ trans('lang.skills') }}</h2>
                    </div>
                <fieldset>
                    <div class="wt-widgetcontent">
                        <fieldset>
                            <div class="form-group">
                                <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_skills') }}">
                                <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                            </div>
                        </fieldset>
                    @if (!empty($skills))
                   
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($skills as $skill)
                                @php $checked = ( !empty($_GET['skill']) && in_array($skill->slug, $_GET['skill'] )) ? 'checked' : ''; @endphp
                                <span class="wt-checkbox">
                                    <input id="skill-{{{ $skill->slug }}}" type="checkbox" name="skill[]" value="{{{ $skill->slug }}}" {{$checked}} >
                                    <label for="skill-{{{ $skill->slug }}}"> <a href="{{ url('blogs/'.$skill->slug) }}"  >{{{ $skill->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                    </div>
                </fieldset>
            </div>
        
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgetcontent">
                <div class="wt-applyfilters">
                    <span>{{ trans('lang.apply_filter') }}<br> {{ trans('lang.changes_by_you') }}</span>
                    {!! Form::submit(trans('lang.btn_apply_filters'), ['class' => 'wt-btn']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</aside>
