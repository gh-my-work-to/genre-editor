$('#get').click(function()
{
	var buf = "";
	$('input[class=chk]').each(function()
	{
		var chk = $(this).prop('checked');
		if(chk == true)
		{
			var bry = $(this).parent('div').children('input[class=line]');
			buf += bry.val() + "\n";
		}
	});
	
	$('#result').val(buf);
});

$('#apply').click(function()
{
	//reset
	$('input[class=chk]').each(function()
	{
		$(this).prop("checked", false);
	});
	
	var divAry = $('div[class=lineDiv]');
	
	var ary = $('#inputArea').val().split("\n\n");
	var buf = "";
	
	for(var i in ary)
	{
		ary[i] = ary[i].replace(/^[\s\n]+/, "").replace(/[\s\n]+$/, "");
		
		if(ary[i].match(/^\s*$/))
		{
			continue;
		}
		var bry = ary[i].split("\n");
		var header = bry[0];
		var reg = new RegExp(">" + header + "<");
		
		divAry.each(function()
		{
			var obj = $(this);
			
			if(obj.html().match(reg))
			{
				var chkObj = obj.children('input[class=chk]'); 
				chkObj.prop('checked', true);
				
				var group = chkObj.attr('group');
				
				$('input[group=' + group + ']').each(function()
				{
					var theLine = $(this).parent('div').children('input[class=line]');
					for(var b in bry)
					{
						var regB = new RegExp(">" + bry[b] + "<");
						if(theLine.val().match(regB))
						{
							$(this).prop('checked', 'checked');
						}
					}
				});
			}
		});
	}
});
