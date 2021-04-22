{extends file='page.tpl'}

{block name='page_content_container'}
    <div id="custom-text">
        <h2>{l s='Successfull Activation' mod='activationbymail'}</h2>
        <p><strong class="dark">{l s="You account has been activated successfully." mod="activationbymail"} <a href="{$letsLoginLink}">{l s="Let's login." mod="activationbymail"}</a></strong></p>
    </div>
{/block}
