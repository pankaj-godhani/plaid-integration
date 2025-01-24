<!--<div wire:loading>-->

<!--    <div role="status">-->

<!--      <svg aria-hidden="true" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">-->

<!--        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>-->

<!--        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>-->

<!--      </svg>-->

<!--      <span class="sr-only">Loading...</span>-->

<!--    </div>-->

<!--</div>-->





<div wire:loading.delay>

    <div style="justify-content: center; align-items: center; background-color: black; position: fixed; top: 0px; left: 0px; z-index: 9999; width: 100%; height: 100%; opacity: .75;">

        <div style="color: #edb948" class="la-ball-spin-clockwise la-2x">

            <div></div>

            <div></div>

            <div></div>

            <div></div>

            <div></div>

            <div></div>

            <div></div>

            <div></div>

        </div>

    </div>

</div>



<!--<?php $__env->startPush('styles'); ?>-->

<style>

    /*!

     * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)

     * Copyright 2015 Daniel Cardoso <@DanielCardoso>

     * Licensed under MIT

     */

    .la-ball-spin-clockwise,

    .la-ball-spin-clockwise > div {

        position: relative;

        -webkit-box-sizing: border-box;

           -moz-box-sizing: border-box;

                box-sizing: border-box;

    }

    .la-ball-spin-clockwise {

        display: block;

        font-size: 0;

        color: #fff;

    }

    .la-ball-spin-clockwise.la-dark {

        color: #333;

    }

    .la-ball-spin-clockwise > div {

        display: inline-block;

        float: none;

        background-color: currentColor;

        border: 0 solid currentColor;

    }

    .la-ball-spin-clockwise {

        width: 32px;

        height: 32px;

    }

    .la-ball-spin-clockwise > div {

        position: absolute;

        top: 50%;

        left: 50%;

        width: 8px;

        height: 8px;

        margin-top: -4px;

        margin-left: -4px;

        border-radius: 100%;

        -webkit-animation: ball-spin-clockwise 1s infinite ease-in-out;

           -moz-animation: ball-spin-clockwise 1s infinite ease-in-out;

             -o-animation: ball-spin-clockwise 1s infinite ease-in-out;

                animation: ball-spin-clockwise 1s infinite ease-in-out;

    }

    .la-ball-spin-clockwise > div:nth-child(1) {

        top: 5%;

        left: 50%;

        -webkit-animation-delay: -.875s;

           -moz-animation-delay: -.875s;

             -o-animation-delay: -.875s;

                animation-delay: -.875s;

    }

    .la-ball-spin-clockwise > div:nth-child(2) {

        top: 18.1801948466%;

        left: 81.8198051534%;

        -webkit-animation-delay: -.75s;

           -moz-animation-delay: -.75s;

             -o-animation-delay: -.75s;

                animation-delay: -.75s;

    }

    .la-ball-spin-clockwise > div:nth-child(3) {

        top: 50%;

        left: 95%;

        -webkit-animation-delay: -.625s;

           -moz-animation-delay: -.625s;

             -o-animation-delay: -.625s;

                animation-delay: -.625s;

    }

    .la-ball-spin-clockwise > div:nth-child(4) {

        top: 81.8198051534%;

        left: 81.8198051534%;

        -webkit-animation-delay: -.5s;

           -moz-animation-delay: -.5s;

             -o-animation-delay: -.5s;

                animation-delay: -.5s;

    }

    .la-ball-spin-clockwise > div:nth-child(5) {

        top: 94.9999999966%;

        left: 50.0000000005%;

        -webkit-animation-delay: -.375s;

           -moz-animation-delay: -.375s;

             -o-animation-delay: -.375s;

                animation-delay: -.375s;

    }

    .la-ball-spin-clockwise > div:nth-child(6) {

        top: 81.8198046966%;

        left: 18.1801949248%;

        -webkit-animation-delay: -.25s;

           -moz-animation-delay: -.25s;

             -o-animation-delay: -.25s;

                animation-delay: -.25s;

    }

    .la-ball-spin-clockwise > div:nth-child(7) {

        top: 49.9999750815%;

        left: 5.0000051215%;

        -webkit-animation-delay: -.125s;

           -moz-animation-delay: -.125s;

             -o-animation-delay: -.125s;

                animation-delay: -.125s;

    }

    .la-ball-spin-clockwise > div:nth-child(8) {

        top: 18.179464974%;

        left: 18.1803700518%;

        -webkit-animation-delay: 0s;

           -moz-animation-delay: 0s;

             -o-animation-delay: 0s;

                animation-delay: 0s;

    }

    .la-ball-spin-clockwise.la-sm {

        width: 16px;

        height: 16px;

    }

    .la-ball-spin-clockwise.la-sm > div {

        width: 4px;

        height: 4px;

        margin-top: -2px;

        margin-left: -2px;

    }

    .la-ball-spin-clockwise.la-2x {

        width: 64px;

        height: 64px;

    }

    .la-ball-spin-clockwise.la-2x > div {

        width: 16px;

        height: 16px;

        margin-top: -8px;

        margin-left: -8px;

    }

    .la-ball-spin-clockwise.la-3x {

        width: 96px;

        height: 96px;

    }

    .la-ball-spin-clockwise.la-3x > div {

        width: 24px;

        height: 24px;

        margin-top: -12px;

        margin-left: -12px;

    }

    /*

     * Animation

     */

    @-webkit-keyframes ball-spin-clockwise {

        0%,

        100% {

            opacity: 1;

            -webkit-transform: scale(1);

                    transform: scale(1);

        }

        20% {

            opacity: 1;

        }

        80% {

            opacity: 0;

            -webkit-transform: scale(0);

                    transform: scale(0);

        }

    }

    @-moz-keyframes ball-spin-clockwise {

        0%,

        100% {

            opacity: 1;

            -moz-transform: scale(1);

                 transform: scale(1);

        }

        20% {

            opacity: 1;

        }

        80% {

            opacity: 0;

            -moz-transform: scale(0);

                 transform: scale(0);

        }

    }

    @-o-keyframes ball-spin-clockwise {

        0%,

        100% {

            opacity: 1;

            -o-transform: scale(1);

               transform: scale(1);

        }

        20% {

            opacity: 1;

        }

        80% {

            opacity: 0;

            -o-transform: scale(0);

               transform: scale(0);

        }

    }

    @keyframes  ball-spin-clockwise {

        0%,

        100% {

            opacity: 1;

            -webkit-transform: scale(1);

               -moz-transform: scale(1);

                 -o-transform: scale(1);

                    transform: scale(1);

        }

        20% {

            opacity: 1;

        }

        80% {

            opacity: 0;

            -webkit-transform: scale(0);

               -moz-transform: scale(0);

                 -o-transform: scale(0);

                    transform: scale(0);

        }

    }

</style>

<!--<?php $__env->stopPush(); ?>--><?php /**PATH C:\xampp8.0\htdocs\plaid\resources\views/components/loader.blade.php ENDPATH**/ ?>