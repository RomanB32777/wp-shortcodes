import Swiper from "swiper";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import type { SwiperOptions } from "swiper/types/swiper-options";

import { baseBreakpoints } from "./constants";

export const initSwiperSlider = (containerName: string, options: SwiperOptions = {}) => {
	const { breakpoints, ...swiperOptions } = options;

	return new Swiper(containerName, {
		modules: [Navigation, Pagination, Autoplay],
		slidesPerView: 4,
		spaceBetween: 24,
		autoplay: {
			delay: 5000,
		},
		pagination: {
			clickable: true,
			el: ".swiper-pagination",
			bulletClass: "swiper-bullet group w-3 h-3",
			bulletActiveClass: "nav-active",
			renderBullet(_index: number, className: string) {
				return `
					<button class="${className}">
						<span class="bullet-dot inline-block w-full h-full duration-200 rounded-full bg-primary-light hover:bg-secondary group-[.nav-active]:bg-secondary"></span>
					</button>
				`;
			},
		},
		navigation: {
			nextEl: `.arrow-right-${containerName.replace(/[#.]/gm, "")}`,
			prevEl: `.arrow-left-${containerName.replace(/[#.]/gm, "")}`,
			disabledClass: "nav-disabled",
		},
		breakpoints: {
			[baseBreakpoints.xs]: {
				slidesPerView: 1,
			},
			[baseBreakpoints.sm]: {
				slidesPerView: 2,
			},
			[baseBreakpoints.md]: {
				slidesPerView: 3,
			},
			[baseBreakpoints.xl]: {
				slidesPerView: 4,
				spaceBetween: 24,
			},
			...breakpoints,
		},
		...swiperOptions,
	});
};
