<template>
    <h1 class="text_34 font-play font-bold opacity-80 uppercase my-4 text_ld">{{ $t('pages.news')}}</h1>
	
    <Swiper :pagination="{
                clickable: true,
            }"
            :autoplay="{
                delay: 2200,
                reverseDirection: false,
                disableOnInteraction: false,
                pauseOnMouseEnter: true, // Autoplay pauses on mouse hover
            }"
            :modules="modules"
            :spaceBetween="24"
            class="mySwiper md:h-[350px]">

        <SwiperSlide v-for="element in input"
                     :key="element.id">

            <article class="md:flex block text_ld">
                <div class="md:w-1/2 w-full h-[180px] md:h-[291px] overflow-hidden rounded-[6px] shadow">
                    <img :src="element.image_url"
                         alt="news_image"
                         class="w-full h-full object-cover">
                </div>
                <section class="md:w-1/2 w-full md:px-6 md:py-2 p-0 font-play md:flex md:flex-col">
                    <h1 class="text_34 font-bold opacity-80 mb-3 uppercase"
                        data-swiper-parallax="-100">{{ element.name }}</h1>
                    <p class="text_16"
                       data-swiper-parallax="-200"
                       data-swiper-parallax-opacity="0.5">{{ element.description ?? lorem_text }}</p>
					
                    <div class="md:mt-auto mt-2">
                        <button class="btn_ld btn_main text-xs">{{ $t('details_button') }}</button>
                    </div>
                </section>
            </article>

        </SwiperSlide>
    </Swiper>
</template>
<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css/pagination';
import 'swiper/css';
import {lorem_text} from '@/Pages/Shared/helpers.js';

const modules = [Pagination, Autoplay];
defineProps(['input']);

const onSwiper = (swiper) => {
    console.log(swiper);
};
const onSlideChange = () => {
    console.log('slide change');
};
</script>

