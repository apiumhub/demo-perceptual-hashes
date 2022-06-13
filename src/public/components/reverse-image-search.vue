<script>
module.exports = {
    props: [
        'testsuite'
    ],
    data() {
        return {
            images: null,
            image: null
        }
    },
    mounted () {
        axios.get("/search.php").then((result) => {
            this.images = result.data
        });
    },
    methods: {
        searchByImage(filename) {
            this.image = filename;

            axios.get("/search.php", {
                params: {
                    image: filename
                }
            }).then((result) => {
                this.images = result.data
            });
        }
    }
}
</script>

<template>
    <section class="app">
        <nav>
            <i class="fa-solid fa-magnifying-glass selected"></i>
            <i class="fa-solid fa-fire-flame-curved"></i>
            <i class="fa-solid fa-layer-group"></i>
            <i class="fa-solid fa-ellipsis"></i>
        </nav>

        <aside>
            <h2>Reverse Image Search</h2>

            <dl>
                <dt>Compare with...</dt>

                <dd class="grid">
                    <button
                        v-for="item in testsuite"
                        @click="searchByImage(item)"
                        v-bind:class="{ selected: image == item }"
                        v-bind:style="{ backgroundImage: 'url(' + item + ')' }"
                    ></button>
                </dd>
                <dd>
                    <button @click="searchByImage(null)" v-bind:class="{ selected: this.image == null  }">Reset</button>
                </dd>
            </dl>

            <dl>
                <dt>Categories</dt>

                <dd>
                    <a class="selected"><i class="fa-solid fa-circle"></i> Category #1</a>
                    <a><i class="fa-solid fa-circle"></i> Category #2</a>
                </dd>
            </dl>
        </aside>

        <main>
            <header>
                <input type="search" placeholder="Type to search..." />

                <div class="tags">
                    <a>Modern</a>
                    <a>Classic</a>
                    <a>Bold</a>
                </div>

                <div class="layout">
                    <a class="selected"><i class="fa-solid fa-bars"></i></a>
                    <a><i class="fa-solid fa-table-cells"></i></a>
                </div>
            </header>

            <footer>
                <div class="results">
                    <figure v-for="item in images">
                        <div :style="{ backgroundImage: 'url(' + item.path + ')' }"></div>

                        <figcaption v-if="item.distance != null" title="Distance" v-bind:data-distance="item.distance"></figcaption>
                    </figure>
                </div>

                <nav class="pagination">
                    <a><i class="fa-solid fa-angles-left"></i></a>
                    <a><i class="fa-solid fa-angle-left"></i></a>
                    <a class="selected">1</a>
                    <a>2</a>
                    <a>3</a>
                    <a>...</a>
                    <a>9</a>
                    <a><i class="fa-solid fa-angle-right"></i></a>
                    <a><i class="fa-solid fa-angles-right"></i></a>
                </nav>
            </footer>
        </main>
    </section>
</template>

<style>
:root {
  --highlighted-color-primary: #4519e9;
  --highlighted-color-secondary: white;

  --nav-color-bg: #1b1a2e;
  --nav-color-text: #585679;

  --aside-color-bg: #110b1c;
  --aside-box-color-bg: #1b1522;
  --aside-box-color-text: #9a97a5;

  --box-color-bg: #2b1e38;
}

section.app {
    width: 100%;
    height: calc(100vh - 80px);
    border-radius: 10px;
    box-shadow: 0px 2px 8px rgba(0,0,0, .5);
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: flex-start;
    align-content: stretch;
}
section.app > nav {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    background-color: var(--nav-color-bg);
    width: 60px;
    padding: 0 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    justify-content: center;
    align-content: center;
}
section.app > nav > i {
    color: var(--nav-color-text);
}
section.app > nav > i.selected {
    color: var(--highlighted-color-primary);
}
section.app > nav > i:not(:first-child) {
    margin-top: 40px;
}
section.app > nav > i:not(.selected):hover {
    color: var(--highlighted-color-secondary);
}
section.app > aside {
    background-color: var(--aside-color-bg);
    padding: 20px 40px;
    width: 340px;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    justify-content: start;
    align-content: left;
}
section.app > aside h2 {
    font-weight: bolder;
    font-size: x-large;
    margin-bottom: 20px;
}
section.app > aside dl {
    font-size: small;
    background-color: var(--aside-box-color-bg);
    padding: 5px;
    border-radius: 3px;
    width: 100%;
    color: var(--aside-box-color-text);
    margin-bottom: 20px;
}
section.app > aside dl dt {
    font-weight: bolder;
    padding: 5px 10px;
}
section.app > aside dl dd {
    padding: 0px 10px;
}
section.app > aside dl dd a {
    display: block;
    text-decoration: none;
}
section.app > aside dl dd a i {
    font-size: 5px;
    vertical-align: middle;
}
section.app > aside dl dd a.selected {
    color: var(--highlighted-color-primary);
}
section.app > aside dl dd a:not(.selected):hover {
    color: var(--highlighted-color-secondary);
}
section.app > aside dl dd.grid {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: start;
}
section.app > aside dl button {
    display: block;
    border: 2px solid transparent;
    cursor: pointer;
    width: 100%;
    padding: 5px 20px;
    text-align: center;
}
section.app > aside dl button.selected {
    border: 2px solid var(--highlighted-color-primary);
}
section.app > aside dl dd.grid button {
    width: 100px;
    height: 75px;
    display: block;
    border: 2px solid transparent;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-radius: 10px;
    cursor: pointer;
    filter: grayscale(100%);
    margin: 0 10px 10px 0;
}
section.app > aside dl dd.grid button.selected {
    border: 2px solid var(--highlighted-color-primary);
    filter: grayscale(0%);
}
section.app > main {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    background-color: #1b1a2e;
    width: calc(100% - 400px);
    padding: 20px 40px;
    display: flex;
    flex-direction: column;
    justify-content: start;
}
section.app > main > header {
    margin-bottom: 10px;
}
section.app > main > header input[type=search] {
    background-color: var(--box-color-bg);
    color: var(--highlighted-color-secondary);
    border-radius: 5px;
    border: 0px none;
    line-height: 24px;
    display: block;
    width: 100%;
    margin-bottom: 10px;
    padding: 2px 10px;
    outline: none;
}
section.app > main > header > div.tags a {
    font-size: x-small;
    padding: 3px 5px;
    background-color: var(--highlighted-color-primary);
    color: var(--highlighted-color-secondary);
    border-radius: 3px;
    font-weight: bolder;
}
section.app > main > header > div.layout {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: flex-end;
    align-content: left;
}
section.app > main > header > div.layout a {
    width: 32px;
    height: 32px;
    background-color: var(--box-color-bg);
    border-radius: 3px;
    text-align: center;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    justify-content: center;
    align-content: center;
}
section.app > main > header > div.layout a:not(:first-child) {
    margin-left: 10px;
}
section.app > main > header > div.layout a i {
    color: var(--nav-color-text);
}
section.app > main > header > div.layout a.selected i {
    color: var(--highlighted-color-primary);
}
section.app > main > header > div.layout a:not(.selected):hover {
     background-color: var(--highlighted-color-primary);
}
section.app > main > header > div.layout a:not(.selected):hover i {
    color: var(--highlighted-color-secondary);
}
section.app > main > footer {
    flex-grow: 1;
    overflow: none;
    overflow-x: none;
    overflow-y: auto;
}
section.app > main > footer > div.results {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: start;
}
section.app > main > footer > div.results figure {
    margin: 0 20px 20px 0;
    padding: 0;
    display: inline-block;
    width: 225px;
    height: 150px;
    border-radius: 10px;
    background-color: rgba(0, 0, 0, 0.5);
    position: relative;
}
section.app > main > footer > div.results figure:before {
    position: absolute;
    display: inline-block;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    white-space: nowrap;
    content: "225 x 125";
    font-size: small;
    z-index: -1;
}
section.app > main > footer > div.results figure > div {
    width: 225px;
    height: 150px;
    display: block;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-radius: 10px;
}
section.app > main > footer > div.results figure figcaption {
    position: absolute;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 20px);
    height: 2px;
    background-color: var(--highlighted-color-primary);
}
section.app > main > footer > div.results figure figcaption:before {
    position: absolute;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    content: attr(data-distance);
    background-color: var(--highlighted-color-primary);
    color: var(--highlighted-color-secondary);
    padding: 2px 10px;
    font-size: x-small;
    font-weight: bolder;
    line-height: 24px;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
section.app > main > footer > nav.pagination {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: center;
    align-content: start;
    font-size: x-small;
}
section.app > main > footer > nav.pagination a {
    width: 32px;
    height: 32px;
    background-color: var(--box-color-bg);
    text-align: center;
    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;
    justify-content: center;
    align-content: center;
}
section.app > main > footer > nav.pagination a:not(.selected):hover {
    background-color: var(--highlighted-color-primary);
}
section.app > main > footer > nav.pagination a:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}
section.app > main > footer > nav.pagination a:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}
section.app > main > footer > nav.pagination a.selected {
    background-color: var(--highlighted-color-primary);
}
section.app > main > footer > nav.pagination a.selected i {
    color: var(--highlighted-color-secondary);
}
</style>