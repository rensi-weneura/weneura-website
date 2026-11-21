/* blog-detail.js
 * Loads one blog from the PHP API into /blog/blog-details/
 * URL format: /blog/blog-details/?slug=my-blog-title
 */
(function () {
  'use strict';

  // API base domain
  var API_BASE = location.hostname === 'www.weneurafuturetech.com'
    ? 'https://api.weneurafuturetech.com'
    : 'http://192.168.1.57:8000';

  var FALLBACK_IMG = '/assets/img/post-default.png';
  var FALLBACK_AVATAR = '/assets/img/author-avatar-1.jpg';
  var AUTHOR_NAME = 'Siddharth Varsani'; // API has no author field

  var $ = function (id) { return document.getElementById(id); };

  function esc(str) {
    var d = document.createElement('div');
    d.textContent = str == null ? '' : String(str);
    return d.innerHTML;
  }

  function formatDate(value) {
    var d = new Date(String(value).replace(' ', 'T'));
    if (isNaN(d)) return '';
    return d.toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
  }

  function readingTime(html) {
    var text = String(html || '').replace(/<[^>]*>/g, ' ');
    var words = text.trim().split(/\s+/).filter(Boolean).length;
    return Math.max(1, Math.ceil(words / 200));
  }

  // Strip scripts, iframes and inline handlers from editor HTML before injecting it
  function sanitize(html) {
    var doc = new DOMParser().parseFromString(html || '', 'text/html');
    doc.querySelectorAll('script, style, iframe, object, embed, link, meta').forEach(function (n) { n.remove(); });
    doc.body.querySelectorAll('*').forEach(function (el) {
      Array.prototype.slice.call(el.attributes).forEach(function (attr) {
        var name = attr.name.toLowerCase();
        var val = attr.value.trim().toLowerCase();
        if (name.indexOf('on') === 0 || ((name === 'href' || name === 'src') && val.indexOf('javascript:') === 0)) {
          el.removeAttribute(attr.name);
        }
      });
    });
    return doc.body.innerHTML;
  }

  function setMeta(selector, value) {
    var el = document.querySelector(selector);
    if (el) el.setAttribute('content', value);
  }

  function showError(message) {
    var body = document.querySelector('.blog-details-body');
    if (body) {
      body.innerHTML =
        '<div class="text-center py-5">' +
        '<h2 class="h4 mb-3">' + esc(message) + '</h2>' +
        '<a href="/blog/" class="btn btn-outline-dark rounded-pill px-4">Back to all articles</a>' +
        '</div>';
    }
    var hero = $('blogTitle');
    if (hero) hero.textContent = 'Article not available';
    var banner = document.querySelector('.blog-details-banner');
    if (banner) banner.style.display = 'none';
    var related = document.querySelector('.blog-related-section');
    if (related) related.style.display = 'none';
  }

  function fetchJson(path) {
    return fetch(API_BASE + path, { headers: { Accept: 'application/json' } }).then(function (res) {
      return res.json().catch(function () { return {}; }).then(function (json) {
        if (!res.ok) {
          var err = new Error(json.message || 'Request failed');
          err.status = res.status;
          throw err;
        }
        return json;
      });
    });
  }

  function renderBlog(blog) {
    var title = blog.title || '';
    var image = blog.image || FALLBACK_IMG;

    document.title = title + ' | Weneura Futuretech';
    setMeta('meta[name="description"]', blog.short_description || '');
    setMeta('meta[property="og:title"]', title);
    setMeta('meta[property="og:description"]', blog.short_description || '');
    setMeta('meta[property="og:image"]', image);
    var slug = blog.slug || blog.id;
    var url = location.origin + '/blog/blog-details/?slug=' + encodeURIComponent(slug);
    setMeta('meta[property="og:url"]', url);
    var canonical = document.querySelector('link[rel="canonical"]');
    if (canonical) canonical.setAttribute('href', url);

    $('blogTitle').textContent = title;
    $('blogDate').textContent = formatDate(blog.created_at);
    $('blogReadTime').textContent = readingTime(blog.long_description) + ' min read';

    var cat = $('blogCategory');
    if (cat) {
      if (blog.category_title) {
        cat.textContent = blog.category_title;
        cat.classList.remove('d-none');
      } else {
        cat.classList.add('d-none');
      }
    }

    var img = $('blogBanner');
    if (img) {
      img.src = image;
      img.alt = title;
      img.onerror = function () { img.onerror = null; img.src = FALLBACK_IMG; };
    }

    var lead = $('blogLead');
    if (lead) lead.textContent = blog.short_description || '';

    var content = $('blogContent');
    if (content) content.innerHTML = sanitize(blog.long_description);
  }

  function renderRelated(currentId, categoryId) {
    var wrap = $('relatedBlogs');
    var section = document.querySelector('.blog-related-section');
    if (!wrap) return;

    var path = '/api/blogs' + (categoryId ? '?category=' + encodeURIComponent(categoryId) : '');
    fetchJson(path).then(function (json) {
      var items = (json.data || []).filter(function (b) { return Number(b.id) !== Number(currentId); });

      // Not enough in the same category: top up with the latest from all categories
      if (items.length >= 3 || !categoryId) return items;
      return fetchJson('/api/blogs').then(function (all) {
        var ids = items.map(function (b) { return b.id; });
        var extra = (all.data || []).filter(function (b) {
          return Number(b.id) !== Number(currentId) && ids.indexOf(b.id) === -1;
        });
        return items.concat(extra);
      });
    }).then(function (items) {
      items = (items || []).slice(0, 3);
      if (!items.length) { if (section) section.style.display = 'none'; return; }

      wrap.innerHTML = items.map(function (b) {
        return '' +
          '<div class="col-lg-4 col-md-6">' +
          '<a href="/blog/blog-details/?slug=' + encodeURIComponent(b.slug || b.id) + '" class="blog-overlay-card">' +
          '<img src="' + esc(b.image || FALLBACK_IMG) + '" alt="' + esc(b.title) + '" class="blog-overlay-img" ' +
          'onerror="this.onerror=null;this.src=\'' + FALLBACK_IMG + '\'">' +
          '<div class="blog-overlay-scrim"></div>' +
          '<div class="blog-overlay-top">' +
          '<img src="' + FALLBACK_AVATAR + '" alt="' + esc(AUTHOR_NAME) + '" class="blog-author-avatar">' +
          '<span class="blog-author-name">' + esc(AUTHOR_NAME) + '</span>' +
          '</div>' +
          '<div class="blog-overlay-bottom">' +
          '<div class="blog-overlay-meta">' +
          (b.category_title ? esc(b.category_title) + ' &nbsp;•&nbsp; ' : '') + esc(formatDate(b.created_at)) +
          '</div>' +
          '<h3 class="blog-overlay-title">' + esc(b.title) + '</h3>' +
          '</div>' +
          '</a>' +
          '</div>';
      }).join('');
    }).catch(function () {
      if (section) section.style.display = 'none';
    });
  }


  function getSlugOrId() {
    // 1. Check query parameters first (?slug=... or ?id=...)
    var params = new URLSearchParams(location.search);
    if (params.get('slug')) return params.get('slug');
    if (params.get('id')) return params.get('id');

    // 2. Extract slug from clean URL path: /blog/software-developer-system
    var segments = location.pathname.replace(/\/+$/, '').split('/');
    var last = segments.pop();
    if (last && last !== 'blog' && last !== 'blog-details' && last !== 'blog-details.html' && last !== 'index.html') {
      return decodeURIComponent(last);
    }
    return null;
  }

  function init() {
    var identifier = getSlugOrId();
    if (!identifier) { showError('No article selected.'); return; }

    fetchJson('/api/blogs/' + encodeURIComponent(identifier)).then(function (json) {
      if (!json.data) throw new Error('Blog not found');
      renderBlog(json.data);
      renderRelated(json.data.id, json.data.category_id);
    }).catch(function (err) {
      showError(err.status === 404 ? 'This article was not found.' : 'Could not load this article. Please try again.');
    });
  }

  document.addEventListener('DOMContentLoaded', init);
})();