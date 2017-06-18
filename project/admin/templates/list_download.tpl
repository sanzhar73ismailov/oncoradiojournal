{$smarty.foreach.foo.iteration}

{foreach $publications as $item}

		
{foreach $item.authors_array as $a} 
{$a->last_name}
			{$a->first_name|mb_substr:0:1}.{$a->patronymic_name|mb_substr:0:1}.
			{/foreach} {$item.name}// {$item.source}. {$item.year}
{/foreach}