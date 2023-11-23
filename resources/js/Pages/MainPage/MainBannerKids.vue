<template>
    <div class="overflow-hidden shadow mt-12 image-slider relative rounded-[6px]">
        <img class="w-full h-full object-contain"
             src='/img/banners/banner-fc1.jpg'
             alt="1">
        <img class="w-full h-full object-contain absolute"
             src='/img/banners/banner-fc2.jpg'
             alt="2">
        <img class="w-full h-full object-contain absolute"
             src='/img/banners/banner-fc3.jpg'
             alt="3">
        <img class="w-full h-full object-contain absolute"
             src='/img/banners/banner-fc4.jpg'
             alt="4">
    </div>
</template>
<style>
.image-slider {
	width: 100%;
}

.image-slider img {
	top: 0;
	left: 0;
	width: 100%;
	height: auto;
	object-fit: cover;
	opacity: 0;
	animation: imageFade 12s infinite;
}

.image-slider img:nth-child(1) {
	animation-delay: 0s;
}

.image-slider img:nth-child(2) {
	animation-delay: 3s;
}

.image-slider img:nth-child(3) {
	animation-delay: 6s;
}

.image-slider img:nth-child(4) {
	animation-delay: 9s;
}

@keyframes imageFade {
	0% {
		opacity: 0;
	}
	17% {
		opacity: 1;
	}
	33% {
		opacity: 1;
	}
	50% {
		opacity: 0;
	}
	100% {
		opacity: 0;
	}
}

</style>
