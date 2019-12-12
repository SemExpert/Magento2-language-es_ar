<?php
/**
 * Get updated package from crowdin and build dictionary
 */

function main($argv = [])
{
    if (!empty($argv[1])) {
        echo "Versions are deprecated. Only master branch is being used.\n";
    }

    return downloadPackage() || unzipPackage() || compileTranslation();

}

function downloadPackage()
{
    if (!file_exists('./tmp')) {
        mkdir('./tmp');
    }

    $target = fopen('./tmp/package.zip', 'w+');
    $debug = fopen('./tmp/debug.log', 'w+');

    $packageUrl = 'https://crowdin.com/backend/download/project/magento-2/es-AR.zip';
    $curl = curl_init($packageUrl);

    curl_setopt_array(
        $curl,
        [
            CURLOPT_URL => $packageUrl,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FILE => $target,
            CURLOPT_WRITEHEADER  => $debug,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ]
    );

    $response = curl_exec($curl);

    if ($response === false) {
        echo 'Curl error: ' . curl_error($curl) . "\n";
        return 2;
    }

    return 0;
}

function unzipPackage()
{
    $zip = new ZipArchive();
    $res = $zip->open('./tmp/package.zip');

    if ($res === true) {
        if (!file_exists('./tmp/src')) {
            mkdir('./tmp/src');
        }

        $zip->extractTo('./tmp/src');
        $zip->close();
    } else {
        echo "Zip error: $res\n";
        return 4;
    }

    return 0;
}

function compileTranslation()
{
    $actualVersion = 'master';

    $rows = array_merge(
        compilePart('module', './tmp/src/' . $actualVersion . '/app/code'),
        compilePart('theme', './tmp/src/' . $actualVersion . '/app/design/frontend'),
        compilePart('lib', './tmp/src/' . $actualVersion . '/lib/web')
    );

    usort(
        $rows,
        function (array $row1, array $row2) {
            return strcmp($row1[0], $row2[0]);
        }
    );

    $target = fopen('./es_AR.csv', 'w');

    foreach ($rows as $row) {
        fputcsv($target, $row);
    }

    return 0;
}

function collectVersions()
{
    $paths = glob('./tmp/src/*.*', GLOB_ONLYDIR);

    return array_map(
        function ($path) {
            return str_replace('./tmp/src/', '', $path);
        },
        $paths
    );
}

function getActualVersion($targetVersion, $versions)
{
    $numVersions = count($versions);
    $actualVersion = '';

    for ($i = 0; $i < $numVersions; $i++) {
        if (version_compare($targetVersion, $versions[$i]) <= 0) {
            $actualVersion = $versions[$i];
            break;
        }
    }

    if (empty($actualVersion)) {
        $actualVersion = end($versions);
    }

    return $actualVersion;
}

function compilePart($type, $path)
{
    $directory = dir($path);
    $rows = [];

    while ($vendor = $directory->read()) {
        if (shouldSkipDirectory($vendor)) {
            continue;
        }

        $vendorDir = dir($path . '/' . $vendor);

        while ($module = $vendorDir->read()) {
            if (shouldSkipDirectory($module)) {
                continue;
            }

            $modulePath = $path . '/' . $vendor . '/' . $module;
            $translationPath = $modulePath . '/i18n/es_AR.csv';

            if (!file_exists($translationPath)) {
                continue;
            }

            $file = fopen($translationPath, 'r');

            while ($newRow = fgetcsv($file)) {
                $newRow[] = $type;
                $newRow[] = getModuleName($type, $modulePath);
                $rows[] = $newRow;
            }
        }
    }

    return $rows;
}

function getModuleName($type, $path)
{
    $parts = explode('/', $path);

    switch ($type) {
        case 'theme':
            return $parts[6] . '/' . $parts[7] . '/' . $parts[8];
        case 'lib':
            return 'lib/web';
        default:
            return $parts[6] . '_' . $parts[7];
    }
}

function shouldSkipDirectory($path)
{
    return $path == "." || $path == "..";
}

$status = main($argv);
exit($status);