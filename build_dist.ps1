# Build Distribution Script

$ErrorActionPreference = "Stop"
$rootDir = Get-Location
$distDir = "$rootDir\dist"
$yakProPath = "$rootDir\tools\yakpro-po\yakpro-po.php"
$configFile = "$rootDir\yakpro-po.cnf"

# 1. Clean/Create dist directory
Write-Host "Cleaning dist directory..."
if (Test-Path $distDir) {
    Remove-Item -Path $distDir -Recurse -Force
}
New-Item -ItemType Directory -Path $distDir | Out-Null

# 2. Define Exclusions
$excludedItems = @(
    ".git", ".gitignore", "README.md", "composer.json", "composer.lock",
    "yakpro-po.cnf", "build_dist.ps1", "dist",
    "database/create.sql", "database/insert_demo_data.sql", "test", "scripts", "tools", ".gemini", "templates", "assets/css/report.css"
)

# 3. Processing Function
function Process-Item ($itemPath) {
    $relativePath = $itemPath.Substring($rootDir.Path.Length + 1)
    $targetPath = Join-Path $distDir $relativePath
    $parentDir = Split-Path $targetPath -Parent

    # Check Exclusions
    foreach ($exclude in $excludedItems) {
        if ($relativePath -match "^$exclude" -or $relativePath -eq $exclude) {
            # Write-Host "Skipping $relativePath" -ForegroundColor Gray
            return
        }
    }

    if (!(Test-Path $parentDir)) {
        New-Item -ItemType Directory -Path $parentDir -Force | Out-Null
    }

    if ($itemPath.ToString().EndsWith(".php")) {
        # Obfuscate PHP files (skip vendor folder from obfuscation, just copy)
        if ($relativePath -match "^vendor") {
             Copy-Item -Path $itemPath -Destination $targetPath
        } else {
            Write-Host "Obfuscating $relativePath..." -ForegroundColor Cyan
            # yakpro-po outputs to stdout, so we pipe it or use -o if supported (it usually is)
            # using php direct call
            $cmd = "php $yakProPath --config-file $configFile $itemPath -o $targetPath"
            Invoke-Expression $cmd
            
            if ($LASTEXITCODE -ne 0) {
                 Write-Warning "Failed to obfuscate $relativePath. Copying original."
                 Copy-Item -Path $itemPath -Destination $targetPath
            }
        }
    } else {
        # Copy other files
        Copy-Item -Path $itemPath -Destination $targetPath
    }
}

# 4. Iterate and Process
Write-Host "Starting build process..."
Get-ChildItem -Path $rootDir -Recurse | ForEach-Object {
    if (!$_.PSIsContainer) {
        Process-Item $_.FullName
    }
}

Write-Host "Build Complete!" -ForegroundColor Green
Write-Host "Distribution is located at: $distDir"
