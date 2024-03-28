import { type Swiper } from "swiper";
import type { SwiperOptions } from "swiper/types/swiper-options";

import { initSwiperSlider } from "./init-slider";
import { baseBreakpoints } from "./constants";

const sliderElementName = "swiper-shortcode-slider";

const breakpoint = window.matchMedia(`(min-width:${baseBreakpoints.lg}px)`);

let swipers: Swiper[] = [];

const breakpointChecker = () => {
	swipers = swipers.filter((item) => !item.destroyed);

	if (breakpoint.matches) {
		swipers.forEach((item) => item.destroy(true, true));
	} else {
		return enableSwiper();
	}
};

const enableSwiper = () => {
	const sliders = document.querySelectorAll<HTMLDivElement>(`.${sliderElementName}`);

	for (let i = 0; i < sliders.length; i++) {
		const slider = sliders[i];

		const { id } = slider;

		if (id) {
			const isLoop = slider.getAttribute("data-slider-loop") === "true";
			const isDisableAutoplay = slider.getAttribute("data-slider-disable-autoplay");
			const autoplayDelay = slider.getAttribute("data-slider-autoplay-delay");

			const xsSlidesPerView = slider.getAttribute("data-slides-per-view-xs");
			const smSlidesPerView = slider.getAttribute("data-slides-per-view-sm");
			const mdSlidesPerView = slider.getAttribute("data-slides-per-view-md");

			const xsSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-xs");
			const smSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-sm");
			const mdSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-md");

			const baseSpaceBetween = 24;

			const swiperOptions: SwiperOptions = {
				loop: isLoop,
				navigation: false,
				breakpoints: {
					[baseBreakpoints.xs]: {
						slidesPerView: Number(xsSlidesPerView) || 1,
						spaceBetween: Number(xsSlidesSpaceBetween) || baseSpaceBetween,
					},
					[baseBreakpoints.sm]: {
						slidesPerView: Number(smSlidesPerView) || 2,
						spaceBetween: Number(smSlidesSpaceBetween) || baseSpaceBetween,
					},
					[baseBreakpoints.md]: {
						slidesPerView: Number(mdSlidesPerView) || 3,
						spaceBetween: Number(mdSlidesSpaceBetween) || baseSpaceBetween,
					},
				},
				autoplay:
					isDisableAutoplay === "true"
						? false
						: {
								delay: Number(autoplayDelay) || 5000,
							},
			};

			swipers.push(initSwiperSlider(`#${id}`, swiperOptions));
		}
	}
};

breakpoint.onchange = breakpointChecker;
breakpointChecker();
