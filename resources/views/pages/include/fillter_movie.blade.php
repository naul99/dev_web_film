<div class="section-bar clearfix">
    <div class="row">
        <style>
            .stylish_filter{
                border: 0;
                background: #102e46;
                color: #fff;
            }
            .btn_filter{
                border: 0;
                background: #fff;
                color: #414141;
            }
        </style>
        <form style="padding-left: 1%;padding-right: 1%;" action="{{ route('locphim') }}" method="GET">

            <div class="col-md-2">
                <div class="form-group">

                    <select class="form-control stylish_filter" name="order" id="exampleFormControlSelec">
                        <option value="">--Sort--</option>
                        <option value="created_at">Ngay dang</option>
                        <option value="title">Ten phim A-Z</option>
                        <option value="count_views">Luot xem</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control stylish_filter" name="category" id="exampleFormControlSelect1">
                        <option value="">--Danh muc--</option>
                        @foreach ($category as $key => $cate)
                            <option {{ isset($_GET['category']) && $_GET['category'] == $cate->id ? 'selected' : '' }}
                                value="{{ $cate->id }}">{{ $cate->title }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control stylish_filter" name="genre" id="exampleFormControlSelect1">
                        <option value="">--The loai--</option>
                        @foreach ($genre as $key => $gen)
                            <option {{ isset($_GET['genre']) && $_GET['genre'] == $gen->id ? 'selected' : '' }}
                                value="{{ $gen->id }}">{{ $gen->title }}</option>
                        @endforeach

                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">

                    <select class="form-control stylish_filter" name="country" id="exampleFormControlSelect1">
                        <option value="">--Quoc gia--</option>
                        @foreach ($country as $key => $count)
                            <option {{ isset($_GET['country']) && $_GET['country'] == $count->id ? 'selected' : '' }}
                                value="{{ $count->id }}">{{ $count->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">

                    <select class="form-control stylish_filter" name="year" id="exampleFormControlSelect">
                        <option value="">--Nam--</option>
                        @for ($year = 2000; $year <= now()->year; $year++)
                            <option>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <input type="submit" class="btn btn_filter" value="FILTER">
            </div>
            
        </form>
    </div>
</div>

<script>
    function keepSelectedValue() {
        var year = document.getElementById("exampleFormControlSelect");
        year.addEventListener("change", function() {
            var selectedValue = year.options[year.selectedIndex].value;
            localStorage.setItem("selectedYear", selectedValue);
        });
        var selectedYear = localStorage.getItem("selectedYear");
        if (selectedYear !== null) {
            year.value = selectedYear;
        }
    }
    keepSelectedValue();
</script>

