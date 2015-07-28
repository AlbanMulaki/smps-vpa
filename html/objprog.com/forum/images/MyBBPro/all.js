expandables.expandCollapse = function(e, controls)
{
	element = $(e);

	if(!element || controls == false)
	{
		return false;
	}
	var expandedItem = $("#"+controls+"_e");
	var collapsedItem = $("#"+controls+"_c");

	if(expandedItem.length && collapsedItem.length)
	{
		// Expanding
		if(expandedItem.is(":hidden"))
		{
			expandedItem.toggle("fast");
			collapsedItem.toggle("fast");
			this.saveCollapsed(controls);
		}
		// Collapsing
		else
		{
			expandedItem.toggle("fast");
			collapsedItem.toggle("fast");
			this.saveCollapsed(controls, 1);
		}
	}
	else if(expandedItem.length && !collapsedItem.length)
	{
		// Expanding
		if(expandedItem.is(":hidden"))
		{
			expandedItem.toggle("fast");
			element.removeClass("collapse_collapsed").addClass("collapse")
								.attr("alt", "[-]")
								.attr("title", "[-]");
			element.parent().parent('td').removeClass('tcat_collapse_collapsed');
			element.parent().parent('.thead').removeClass('thead_collapsed');
			this.saveCollapsed(controls);
		}
		// Collapsing
		else
		{
			expandedItem.toggle("fast");
			element.removeClass("collapse").addClass("collapse_collapsed")
								.attr("alt", "[+]")
								.attr("title", "[+]");
			element.parent().parent('td').addClass('tcat_collapse_collapsed');
			element.parent().parent('.thead').addClass('thead_collapsed');
			this.saveCollapsed(controls, 1);
		}
	}
	return true;
};

$(document).ready(function()
{
	$(".expcolimage .expander").each(function()
	{
		if($(this).data('src'))
		{
			$(this).addClass($(this).data('src').replace('.png', ''));
		}
	});

	$('.avatar').error(function()
	{
		$(this).unbind("error").attr('src', 'images/MyBBPro/default_avatar.png');
	});
	$('[data-toggle="tooltip"]').tooltip();
	$(window).scroll(function()
	{http://localhost/mybb_18last/member.php?action=profile&uid=1
		h = $(this).height();
		t = $(this).scrollTop();
		if($(this).height() <= 300)
		{
			if(t > 49)
			{
				$('.usercp_nav').css('top', '0');
			}
			else
			{
				$('.usercp_nav').css('top', (49-t)+'px');
			}
		}
	});
});