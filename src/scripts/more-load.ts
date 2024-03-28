// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
jQuery(document).ready(function ($) {
	"use strict";

	const isLastPage = () => {
		return $("#is-all-pages").length;
	};

	const moreButton = $(".load-more");

	const handleButtonActiveStatus = () => {
		moreButton.toggleClass("opacity-75");
		moreButton.toggleClass("pointer-events-none");
	};

	let paged = 1;

	moreButton.on("click", function () {
		const itemsNumber = $(this).attr("data-items-number"),
			blockId = $(this).attr("data-block-id"),
			orderBy = $(this).attr("data-order-by"),
			order = $(this).attr("data-order"),
			columnsNumber = $(this).attr("data-columns-number"),
			isEnableSlider = $(this).attr("data-enable-slider"),
			cardStyle = $(this).attr("data-card-style"),
			excludeId = $(this).attr("data-exclude-id"),
			moreText = $(this).attr("data-more-text"),
			lessText = $(this).attr("data-less-text"),
			wrapperBlock = $(`#shortcode-organizations-${blockId}`);

		if (!wrapperBlock) {
			return;
		}

		const cardList = wrapperBlock.find(".shortcode-cards"),
			btnWrapper = wrapperBlock.find(".more-btn"),
			label = btnWrapper.find("span");

		if (isLastPage()) {
			$(this).attr("alt", moreText);
			$(this).toggleClass("rotate-180");
			label.text(moreText);

			cardList.empty();
			paged = 0;

			$("html, body").animate(
				{
					scrollTop: wrapperBlock.offset().top - 100,
				},
				500
			);
		}

		$.ajax({
			type: "POST",
			// eslint-disable-next-line @typescript-eslint/ban-ts-comment
			// @ts-ignore
			url: ajax_data?.ajax_url,
			dataType: "html",
			data: {
				action: "load_more_organizations",
				itemsNumber,
				orderBy,
				order,
				excludeId,
				columnsNumber,
				isEnableSlider,
				cardStyle,
				paged: ++paged,
			},
			beforeSend() {
				handleButtonActiveStatus();
			},
			success(res: string) {
				cardList?.append(res);

				if (isLastPage()) {
					moreButton.toggleClass("rotate-180");
					moreButton.attr("alt", lessText);
					label.text(lessText);
				}
			},
			complete() {
				handleButtonActiveStatus();
			},
		});
	});
});
