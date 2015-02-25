<html>
    <style type="text/css">
        div.fileinputs {
            position: relative;
        }

        div.fakefile {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 1;
        }

        div.fakefile input[type=button] {
            /* enough width to completely overlap the real hidden file control */
            cursor: pointer;
            width: 148px;
        }

        div.fileinputs input.file {
            position: relative;
            text-align: right;
            -moz-opacity:0 ;
            filter:alpha(opacity: 0);
            opacity: 0;
            z-index: 2;
        }
    </style>

    <div class="fileinputs">
        <input type="file" class="file" />

        <div class="fakefile">
            <input type="button" value="Select file" />
        </div>
    </div>
</html>
