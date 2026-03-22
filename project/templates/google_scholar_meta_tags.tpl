{if $page == 'abstract' && isset($publication)}

    <link rel="canonical" href="https://{$server_name}/index.php?page=abstract&id={$id}" />
    <meta name="citation_title" content="{$publication->name}"/>
    {foreach from=$authors item=author}
        <meta name="citation_author" content="{$author->last_name} {$author->first_name}"/>
    {/foreach}
    <meta name="citation_publication_date" content="{$issue->year}"/>
    <meta name="citation_journal_title" content="{$text['journal_name']}"/>
    <meta name="citation_volume" content="{$issue->issue}"/>
    <meta name="citation_issue" content="{$issue->number}"/>
    <meta name="citation_firstpage" content="{$publication->p_first}"/>
    <meta name="citation_lastpage" content="{$publication->p_last}"/>
    <meta name="citation_pdf_url" content="http://{$server_name}/archive/papers/{$publication->file}"/>
    <meta name="citation_language" content="{$publication->language_iso}"/>
    <meta name="description" content="{$publication->abstract|strip_tags|truncate:300}" />
    <meta name="citation_abstract" content="{$publication->abstract}" />
    <meta name="citation_keywords" content="{$publication->keywords}" />

    <meta property="og:title" content="{$publication->name}" />
    <meta property="og:type" content="article" />
{/if}