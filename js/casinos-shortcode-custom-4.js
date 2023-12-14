jQuery(document).ready(function ($) {
	"use strict";

	const isLastPage = () => {
		return $("#is-all-pages").length;
	};

	const moreButton = $("#load-more"),
		cardList = $(".space-shortcode-4-items"),
		wrapperBlock = $(".space-shortcode-custom-4"),
		btnWrapper = $(".space-shortcode-custom-4-btn"),
		moreText = "もっと見せる",
		lessText = "あまり見せない";

	let paged = 1;

	moreButton.on("click", function () {
		const itemsNumber = $(this).attr("data-items-number"),
			orderBy = $(this).attr("data-order-by"),
			order = $(this).attr("data-order"),
			externalLink = $(this).attr("data-external-link"),
			excludeId = $(this).attr("data-exclude-id"),
			starsNumber = $(this).attr("data-stars-number"),
			label = btnWrapper.find("span");

		// $(this).parent()

		if (isLastPage()) {
			$(this).attr("alt", moreText);
			$(this).toggleClass("less");
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
			url: ajaxData.ajax_url,
			dataType: "html",
			data: {
				action: "load_casinos_shortcode_custom_4",
				itemsNumber,
				orderBy,
				order,
				externalLink,
				excludeId,
				starsNumber,
				paged: ++paged,
			},
			beforeSend(xhr) {
				moreButton.toggleClass("disabled");
			},
			success(res) {
				cardList?.append(res);

				if (isLastPage()) {
					moreButton.toggleClass("less");
					moreButton.attr("alt", lessText);
					label.text(lessText);
				}
			},
			complete(data) {
				moreButton.toggleClass("disabled");
			},
		});
	});
});
