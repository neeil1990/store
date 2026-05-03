/**
 * Копирует woff/woff2 из @fontsource в public/fonts и пересобирает
 * public/css/source-sans-3-local.css и figtree-local.css (абсолютные url для статики public/html).
 */
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');

function copyDir(src, dest) {
    fs.mkdirSync(dest, { recursive: true });
    for (const ent of fs.readdirSync(src, { withFileTypes: true })) {
        const from = path.join(src, ent.name);
        const to = path.join(dest, ent.name);
        if (ent.isDirectory()) {
            copyDir(from, to);
        } else {
            fs.copyFileSync(from, to);
        }
    }
}

function rewriteFontUrls(css, publicUrlPrefix) {
    return css.replace(/url\(\.\/files\//g, `url(${publicUrlPrefix}`);
}

function requirePkg(rel) {
    const p = path.join(root, rel);
    if (!fs.existsSync(p)) {
        throw new Error(`sync-fonts: missing ${rel} — run npm install`);
    }
    return p;
}

const ss3Root = requirePkg('node_modules/@fontsource/source-sans-3');
const figRoot = requirePkg('node_modules/@fontsource/figtree');

const publicFonts = path.join(root, 'public/fonts');
const publicCss = path.join(root, 'public/css');

fs.rmSync(path.join(publicFonts, 'source-sans-3'), { recursive: true, force: true });
fs.rmSync(path.join(publicFonts, 'figtree'), { recursive: true, force: true });

copyDir(path.join(ss3Root, 'files'), path.join(publicFonts, 'source-sans-3'));
copyDir(path.join(figRoot, 'files'), path.join(publicFonts, 'figtree'));

const ss3Parts = ['300.css', '400.css', '400-italic.css', '700.css'];
let ss3Css = '';
for (const file of ss3Parts) {
    const raw = fs.readFileSync(path.join(ss3Root, file), 'utf8');
    ss3Css += rewriteFontUrls(raw, '/fonts/source-sans-3/');
}
ss3Css += `
body,
.layout-fixed .wrapper {
    font-family: 'Source Sans 3', 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}
`;

const figParts = ['400.css', '600.css'];
let figCss = '';
for (const file of figParts) {
    const raw = fs.readFileSync(path.join(figRoot, file), 'utf8');
    figCss += rewriteFontUrls(raw, '/fonts/figtree/');
}

fs.mkdirSync(publicCss, { recursive: true });
fs.writeFileSync(path.join(publicCss, 'source-sans-3-local.css'), ss3Css.trimStart() + '\n');
fs.writeFileSync(path.join(publicCss, 'figtree-local.css'), figCss.trimStart() + '\n');

console.log('sync-fonts: public/fonts/{source-sans-3,figtree}, public/css/{source-sans-3-local,figtree-local}.css');
