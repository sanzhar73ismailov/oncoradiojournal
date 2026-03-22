<div class="row">

    <!-- Main block -->
    <div class="col-lg-8">

        <!-- Hero -->
        <div class="p-4 mb-4 bg-light rounded shadow-sm">
            <h1 class="h4 mb-3">{$text['title_journal_name']}</h1>
            <p>
                A scientific and practical journal dedicated to oncology and radiology issues,
                founded in 2002.
            </p>
            <p>
                Dear readers,
            </p>
            <p>
                We present to your attention the archive of old journal issues from 2010 to 2017. This resource allows you to access materials from past issues and abstracts that are not available on the current official website.
            </p>
            <p>
                The modern version of the journal is available at the following link:
                <a href="https://ojs.oncojournal.kz/index.php" target="_blank" rel="noopener noreferrer">https://ojs.oncojournal.kz/index.php</a>.
            </p>
            <p>
                We hope the archive will be useful for researchers, educators, and anyone interested in the journal's publications.
            </p>
        </div>

        <!-- Quick actions -->
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <a href="?page=current_issue" class="text-decoration-none">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <div class="fs-1">📖</div>
                            <div>Latest Archive Issue</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="?page=archive" class="text-decoration-none">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <div class="fs-1">📚</div>
                            <div>Archive</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="?page=search" class="text-decoration-none">
                    <div class="card h-100 text-center shadow-sm">
                        <div class="card-body">
                            <div class="fs-1">🔍</div>
                            <div>Search Articles</div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- About the Journal -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5>About the Journal</h5>
                <p>
                    The journal is one of the leading scientific publications in the Republic of Kazakhstan.
                    It is published by {$text['kaznii_name']}.
                </p>
                <p>
                    This site presents an archive of journal issues from 2010–2017.
                    Full texts of articles and abstracts in Kazakh, Russian, and English are available here, which are not found on the current official site.
                </p>
                <p>
                    The modern version of the journal is regularly published and available at:
                    <a href="https://ojs.oncojournal.kz/index.php" target="_blank" rel="noopener noreferrer">https://ojs.oncojournal.kz/index.php</a>.
                </p>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">

        <!-- Latest Issue -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5>Latest Issue</h5>
                <p class="mb-2">
                    {$text['current_issue_menu']}
                </p>
                <a href="?page=current_issue" class="btn btn-primary btn-sm">
                    View
                </a>
            </div>
        </div>

        <!-- Contacts -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Contacts</h5>
                <a href="?page=contacts" class="btn btn-outline-secondary btn-sm">
                    Go to
                </a>
            </div>
        </div>

    </div>

</div>