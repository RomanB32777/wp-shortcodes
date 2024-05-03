import type { Swiper } from "swiper";
import type { SwiperOptions } from "swiper/types/swiper-options";

import { initSwiperSlider } from "./init-slider";
import { baseBreakpoints, type TBreakpoints } from "./constants";

const sliderElementName = "swiper-slider";

const initSliders = () => {
	let swipers: Swiper[] = [];

	const sliders = document.querySelectorAll<HTMLDivElement>(`.${sliderElementName}`);

	const enableSwiper = (slider: HTMLDivElement) => {
		const { id } = slider;

		const isLoop = slider.getAttribute("data-slider-loop") === "true";
		const isDisableNavigation = slider.getAttribute("data-slider-disable-navigation");
		const isDisablePagination = slider.getAttribute("data-slider-disable-pagination");
		const isDisableAutoplay = slider.getAttribute("data-slider-disable-autoplay");
		const autoplayDelay = slider.getAttribute("data-slider-autoplay-delay");

		const xsSlidesPerView = slider.getAttribute("data-slides-per-view-xs");
		const smSlidesPerView = slider.getAttribute("data-slides-per-view-sm");
		const mdSlidesPerView = slider.getAttribute("data-slides-per-view-md");
		const xlSlidesPerView = slider.getAttribute("data-slides-per-view-xl");

		const xsSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-xs");
		const smSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-sm");
		const mdSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-md");
		const xlSlidesSpaceBetween = slider.getAttribute("data-slides-space-between-xl");

		const baseSpaceBetween = 24;

		const swiperOptions: SwiperOptions = {
			loop: isLoop,
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
				[baseBreakpoints.xl]: {
					slidesPerView: Number(xlSlidesPerView) || 4,
					spaceBetween: Number(xlSlidesSpaceBetween) || baseSpaceBetween,
				},
			},
			autoplay:
				isDisableAutoplay === "true"
					? false
					: {
							delay: Number(autoplayDelay) || 5000,
						},
		};

		if (isDisableNavigation === "true") {
			swiperOptions.navigation = false;
		}

		if (isDisablePagination === "true") {
			swiperOptions.pagination = false;
		}

		const swiperSlider = initSwiperSlider(`#${id}`, swiperOptions);

		swipers.push(swiperSlider);

		return swiperSlider;
	};

	const breakpointChecker = (breakpoint: MediaQueryList, slider: HTMLDivElement) => {
		swipers = swipers.filter((item) => !item.destroyed);

		if (breakpoint.matches) {
			const currSwiper = swipers.find((swiper) => swiper?.el.id === slider.id);

			currSwiper?.destroy();
		} else {
			return enableSwiper(slider);
		}
	};

	for (let i = 0; i < sliders.length; i++) {
		const slider = sliders[i];

		const { id } = slider;

		if (!id) {
			continue;
		}

		const swiperSlider = enableSwiper(slider);

		const destroyBreakpoint = slider.getAttribute("data-slider-destroy-breakpoint");

		if (Object.keys(baseBreakpoints).includes(destroyBreakpoint)) {
			const breakpoint = window.matchMedia(
				`(min-width:${baseBreakpoints[destroyBreakpoint as TBreakpoints]}px)`
			);

			if (breakpoint.matches) {
				swiperSlider.destroy();
			}

			breakpoint.onchange = () => breakpointChecker(breakpoint, slider);
		}
	}

	return swipers;
};

initSliders();
