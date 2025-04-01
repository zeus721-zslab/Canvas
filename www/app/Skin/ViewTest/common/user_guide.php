<style>

    .user-guide-title h1{font-size: 3rem;font-weight: bold;}
    .user-guide-title p{ font-size: 1.5rem; }
    .user-guide-title div.char img{display: inline-block;position: sticky;top: 200px;}
    .user-guide-wrap {display: flex;flex-direction: column;gap: 4rem}
    .user-guide-wrap section {display: flex; flex-direction: column;justify-content: center; gap: 2rem}
     .user-guide-wrap section:nth-child(2)
    ,.user-guide-wrap section:nth-child(4){flex-direction: column-reverse}

    .user-guide-wrap section div{display: flex; justify-content: center;width: 100%}
    .user-guide-wrap section div.sec-img img{width: 90%;}
    .user-guide-wrap section div.btm-desc .badge{background-color: var(--bg-color);height: 26px;border-radius: 0;position: relative}

    section a[role=button] { width: 70% }
    section .btm-desc br{display: none}
    .board-group a[role=button] { width: 70% }
    @media (min-width: 992px) {
        section a[role=button] { width: 40% }
        section .btm-desc br{display: inherit}
        .user-guide-title h1{font-size: 3.75rem;font-weight: bold;}
        .user-guide-title p{ font-size: 2.25rem; }
        .user-guide-title{ height: 350px; }
        .user-guide-wrap {gap: 10rem}
        .user-guide-wrap section {display: flex; flex-direction: row;align-items: center;gap: 10rem}
        .user-guide-wrap section:nth-child(2)
        ,.user-guide-wrap section:nth-child(4){flex-direction: row}
        .user-guide-wrap section div{width: 450px}
        .user-guide-wrap section div.sec-img{width: 450px}
        .user-guide-wrap section:nth-child(1) .btm-desc .badge:after
        ,.user-guide-wrap section:nth-child(3) .btm-desc .badge:after{content: "";position: absolute;top: 12px;left:-53px;z-index: 1;background: url(/img/char1.png) no-repeat;width: 56px;height: 48px;background-size: contain;}
        .user-guide-wrap section:nth-child(2) .btm-desc .badge:after
        ,.user-guide-wrap section:nth-child(4) .btm-desc .badge:after{content: "";position: absolute;top: -22px;left:0;z-index: -1;background: url(/img/char2.png) no-repeat;width: 33px;height: 48px;background-size: contain;}
        .board-group a[role=button] { width: 180px; }
    }
</style>
<main>
    <div class="container-fluid w-1560">
        <div class="user-guide-title position-relative d-flex justify-content-center gap-5 mb-5 mb-lg-0 " >
            <div class="char d-none d-lg-inline-block" style="_width: 400px;text-align: right"><img src="/img/char3.png" style="width: 120px;" alt=""></div>
            <div>
                <p class="text-center">꼬망세와 함께 사용하면 더 유용한</p>
                <h1 class="text-center">사용가이드</h1>
            </div>
            <div class="d-none d-lg-inline-block" style="width: 120px;"></div>
        </div>

        <div class="user-guide-wrap">
            <section>
                <div class="sec-desc d-flex flex-column gap-4">
                    <div class="top-desc text-center fs-2">
                        월별 디자인에서<br>
                        이달에 필요한 추천 템플릿을<br>
                        만나볼 수 있어요.
                    </div>
                    <div class="d-flex gap-2 btm-desc justify-content-start">
                        <span class="badge text-black d-flex align-items-center">TIP</span>
                        <div class="fs-5 text-start text-lg-end justify-content-start">
                            꼬망세 홈페이지에 있는 `놀이계획안`을 활용해<br>
                            월별/주제별 놀이를 확인한 뒤 연계해 보세요!
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a role="button" class="btn btn-black py-2" href="<?=route_to('Category','month')?>">월별 디자인 바로 가기</a>
                    </div>
                </div>
                <div class="sec-img">
                    <img src="/img/ug_month.jpg" alt="월별디자인">
                </div>
            </section>
            <section>
                <div class="sec-img">
                    <img src="/img/ug_play.jpg" alt="놀이_행사">
                </div>
                <div class="sec-desc d-flex flex-column gap-4">
                    <div class="top-desc text-center fs-2">
                        카테고리별 행사/놀이에서<br>
                        필요한 자료를 찾아볼 수 있어요
                    </div>
                    <div class="d-flex gap-2 btm-desc justify-content-start flex-lg-row flex-row-reverse ">
                        <div class="fs-5 text-start text-lg-end justify-content-end">
                            꼬망세 홈페이지에 있는 `자료 패키지`를 활용해<br>
                            주제별로 다양하게 준비된 놀이자료를<br>
                            함께 사용해 보세요!
                        </div>
                        <span class="badge text-black d-flex align-items-center">TIP</span>
                    </div>
                    <div class="d-flex justify-content-center gap-5">
                        <a role="button" class="btn btn-black py-2" href="<?=route_to('Category','event')?>">행사 바로 가기</a>
                        <a role="button" class="btn btn-black py-2" href="<?=route_to('Category','play')?>">놀이 바로 가기</a>
                    </div>
                </div>
            </section>
            <section>
                <div class="sec-desc d-flex flex-column gap-4">
                    <div class="top-desc text-center fs-2" style="letter-spacing: -.5px;">
                        생일판, 투약함, 학기별 환경구성 등<br>
                        원 내 필요한 자료를 구할 수 있어요.
                    </div>
                    <div class="d-flex gap-2 btm-desc justify-content-start">
                        <span class="badge text-black d-flex align-items-center">TIP</span>
                        <div class="fs-5 justify-content-start">
                            꼬망세 홈페이지에 있는 `교수자료`를 활용해<br>
                            그림, 가랜드, 합성도안 등 필요한 환경구성 자료를<br>
                            추가로 사용해 보세요!
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a role="button" class="btn btn-black py-2" href="<?=route_to('Category','env')?>">환경구성 바로 가기</a>
                    </div>
                </div>
                <div class="sec-img">
                    <img src="/img/ug_env.jpg" alt="환경구성">
                </div>
            </section>
            <section>
                <div class="sec-img">
                    <img src="/img/ug_noti.jpg" alt="안내문">
                </div>
                <div class="sec-desc d-flex flex-column gap-4">
                    <div class="top-desc text-center fs-2">
                        다양한 템플릿을 통해<br>
                        나만의 안내문과 카드뉴스를<br>만들 수 있어요.
                    </div>
                    <div class="d-flex gap-2 btm-desc justify-content-start flex-lg-row flex-row-reverse ">

                        <div class="fs-5 text-start text-lg-end justify-content-end" style="letter-spacing: -.4px">
                            꼬망세 홈페이지에 있는 `원운영`메뉴를 활용해<br>
                            가정통신문, 양육정보지 등 필요한 안내문을 내려받아<br>
                            가정에 배부해 보세요!
                        </div>
                        <span class="badge text-black d-flex align-items-center">TIP</span>
                    </div>
                    <div class="d-flex justify-content-center gap-5">
                        <a role="button" class="btn btn-black py-2" href="<?=route_to('Category','noti')?>">안내문 바로 가기</a>
                    </div>
                </div>
            </section>

            <div class="board-group d-flex flex-column flex-lg-row justify-content-lg-center align-items-center gap-3 gap-lg-5 mt-3 mt-lg-0">
                <a role="button" class="btn btn-black py-2" href="<?=route_to('Category','month')?>">템플릿 구경하기</a>
                <a role="button" class="btn btn-black py-2" href="https://www.edupre.co.kr/" target="_blank">꼬망세 바로 가기</a>
            </div>
        </div>
    </div>
</main>