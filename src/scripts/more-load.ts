// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-ignore
jQuery(document).ready(function ($) {
	"use strict";

	const isLastPage = () => {
		return $("#is-all-pages").length;
	};

	const moreButton = $(".more-btn");

	const handleButtonActiveStatus = () => {
		moreButton.toggleClass("opacity-75");
		moreButton.toggleClass("pointer-events-none");
	};

	let paged = 1;

	moreButton.on("click", function () {
		const itemsNumber = $(this).attr("data-items-number"),
			postType = $(this).attr("data-post-type"),
			metaKey = $(this).attr("data-meta-key"),
			blockId = $(this).attr("data-block-id"),
			orderBy = $(this).attr("data-order-by"),
			order = $(this).attr("data-order"),
			columnsNumber = $(this).attr("data-columns-number"),
			isEnableSlider = $(this).attr("data-enable-slider"),
			excludeId = $(this).attr("data-exclude-id"),
			moreText = $(this).attr("data-more-text"),
			lessText = $(this).attr("data-less-text"),
			wrapperBlock = $(`#shortcode-posts-${blockId}`);

		if (!wrapperBlock) {
			return;
		}

		const cardList = wrapperBlock.find(".shortcode-cards"),
			label = moreButton.find("span");

		if (isLastPage()) {
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
				action: "load_more_posts",
				itemsNumber,
				postType,
				metaKey,
				orderBy,
				order,
				excludeId,
				columnsNumber,
				isEnableSlider,
				paged: ++paged,
			},
			beforeSend() {
				handleButtonActiveStatus();
			},
			success(res: string) {
				cardList?.append(res);

				if (isLastPage()) {
					label.text(lessText);
				}
			},
			complete() {
				handleButtonActiveStatus();
			},
		});
	});
});
