<footer id="footer" class="clearfix">
    <style>
        .footers a {
            font-size: 14px;
            color: #696969;
        }

        .footers p {
            font-size: 14px;
            color: #696969;
        }

        .footers ul {
            line-height: 30px;
        }



        @media (max-width: 480px) {
            .img-footer {
                width: 30%;
            }
        }

        @media (min-width: 481px) {
            .img-footer {
                width: 100%;
            }
        }
    </style>
    <section class="footers bg-light pt-5 pb-3">
        <div class="container pt-5">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 footers-one">
                    <div class="footers-logo">
                        <img src="{{ asset('uploads/logo/' . $info->logo) }}" alt="Logo" style="width:120px;">
                    </div>
                    <div class="footers-info mt-3">
                        <p>{{ $info->title }}</p>
                    </div>

                </div>
              
                {{-- <div class="col-xs-12 col-sm-6 col-md-2 footers-two">
                    <img class="img-footer" src="{{ asset('uploads/images/logodisney.png') }}" alt="Disney">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2 footers-three">
                    <img class="img-footer" src="{{ asset('uploads/images/Marvel.png') }}" alt="Marvel">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2 footers-four">
                    <img class="img-footer" src="{{ asset('uploads/images/DC.png') }}" alt="DC">
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2 footers-five">
                    <img class="img-footer" src="https://seeklogo.com/images/U/Universal-logo-72A5C164C2-seeklogo.com.png"
                        alt="Universal Pictures"> --}}
               
            </div>
            </div>
        </div>
    </section>
    <section class="disclaimer bg-light border">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 py-2">
                    <small style="font-size: 15px">
                        {{ $info->description }}
                    </small>
                </div>
            </div>
        </div>
    </section>
    <section class="copyright border">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12 pt-3">
                    <p class="text-muted"> © {{ now()->year }} Copyright:
                        <a href="{{ route('homepage') }}" class="text-white">FULLHD Phim</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</footer>
