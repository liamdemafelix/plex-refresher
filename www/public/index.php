<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Plex Refresher</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <style>
        body {
            margin-top: 40px;
            background: #1a1c1e;
            font-family: "-apple-system","BlinkMacSystemFont","Lucida Sans Unicode","Lucida Sans","DejaVu Sans","Bitstream Vera Sans","Liberation Sans","Verdana","Verdana Ref",sans-serif;
        }

        .gray {
            color: #cccccc;
        }

        h1, h2, h3, h4, h5, h6, .orange {
            color: #e8b235;
        }

        .bg-gray {
            background: rgba(255,255,255,0.08);
        }

        .lds-dual-ring {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 0.5em;
        }
        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 18px;
            height: 18px;
            margin: 4px;
            border-radius: 50%;
            border: 2px solid #fff;
            border-color: #fff transparent #fff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }
        .lds-dual-ring.dark:after {
            content: " ";
            display: block;
            width: 18px;
            height: 18px;
            margin: 4px;
            border-radius: 50%;
            border: 2px solid #333;
            border-color: #333 transparent #333 transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }
        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-10 offset-lg-1">
            <h1>Plex Refresher</h1>
            <p class="gray">
                Use this tool to rebuild a movie/TV show's metadata. Useful when Plex couldn't automatically detect your newly-uploaded subtitle.
            </p>
            <div class="bg-gray px-3 py-3">
                <h3>Step 1 - Select a Library</h3>
                <select class="form-control" name="library">
                    <option value="">Select one</option>
                </select>
                <div id="loadingLibraries" class="gray pt-2"><div class="lds-dual-ring"></div> Loading libraries...</div>
                <h3 class="pt-4">Step 2 - Select an Item</h3>
                <select class="form-control" name="item">
                    <option value="">Select one</option>
                </select>
                <div id="loadingItems" class="gray pt-2"><div class="lds-dual-ring"></div> Loading items...</div>
                <div class="pt-4">
                    <button type="button" id="rebuildButton" class="btn btn-warning btn-lg btn-block disabled" disabled>Rebuild</button>
                </div>
            </div>
            <div class="pt-4">
                <h5>It didn't work!</h5>
                <ul class="gray">
                    <li>Did you wait for at least five minutes before panicking?</li>
                    <li>
                        Did you upload the subtitle correctly in Bazarr?
                        <ul>
                            <li>It should be in <code>.srt</code>, <code>.sub</code> or <code>.ass</code> (yes, <code>.ass</code> is an actual file extension) file</li>
                            <li>The button in Bazarr should turn from a purple one that allows you to search to a gray one that displays the language it detected from your uploaded subtitle</li>
                        </ul>
                    </li>
                    <li>
                        Did you select the correct library and media combination above?
                    </li>
                </ul>
                <p class="gray">
                    If you answered <strong>yes</strong> to all of the questions above, ping Liam on Discord for help. He'll ask you the same set of questions before he gets out of bed and fixes it.
                </p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/app.js"></script>
</body>
</html>