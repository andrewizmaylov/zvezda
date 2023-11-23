<template>
    <Swiper :pagination="{
                clickable: true,
            }"
            :slides-per-view="2"
            :autoplay="{
                delay: 2200,
                reverseDirection: false,
                disableOnInteraction: false,
                pauseOnMouseEnter: true, // Autoplay pauses on mouse hover
            }"
            :modules="modules"
            :spaceBetween="24"
            class="mySwiper">
		
        <SwiperSlide v-for="element in images"
                     :key="element.id">
			
            <article class="md:flex block text_ld">
                <div class="w-[100%] overflow-hidden rounded-[6px] shadow">
                    <img :src="cloud_path + element.link"
                         alt="image"
                         class="w-[100%] h-auto object-cover">
                </div>
            </article>
		
        </SwiperSlide>
    </Swiper>
</template>
<script setup>
import {Swiper, SwiperSlide} from 'swiper/vue';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css/pagination';
import 'swiper/css';
import {cloud_path} from '@/Pages/Shared/helpers.js';
const modules = [Pagination, Autoplay];


defineProps(['images']);
</script>