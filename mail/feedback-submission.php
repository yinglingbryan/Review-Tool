<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

$bodyHTML = t('<p>There has been a submission on the Bray &amp; Scarff Review Tool website.</p>

<p><strong>Location</strong>: %s</p>

<p><strong>Name</strong>: %s %s</p>

<p><strong>Email</strong>: %s </p>

<p><strong>Phone</strong>: %s </p>

<p><strong>Comments</strong>: %s </p>

', $location, $firstName, $lastName, $email, $phone, $comments);
