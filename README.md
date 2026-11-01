# deflow

Skills that let an AI coding agent run a web project the way an agency does: brief, references, concept, copy, stack, build, QA, release, and handoff, each stage leaving a file and passing a gate that a script checks.

deflow handles the process. The rules for the words and the design (no generated-looking UI, no stock AI phrasing, no invented facts) live in [agentic-weave](https://github.com/cendysaputra/agentic-weave), and every deflow skill loads `weave-core` from it.

## Skills

- [`deflow`](skills/deflow/SKILL.md): the project flow. Modes `build`, `atm`, `rewrite`, and `audit`; gates G0 to G8; state in `.deflow/` so any agent in any session can continue. `scripts/flow.mjs` refuses to start a stage before the earlier gates pass.
- [`deflow-convert`](skills/deflow-convert/SKILL.md): turns a static build into WordPress (classic with ACF), Elementor V4 JSON, WooCommerce, Statamic 6, Laravel Blade, Astro, or React and Next.js, with tokens from one file and motion that cleans up after itself.
- [`deflow-ref`](skills/deflow-ref/SKILL.md): studies reference sites and builds from them.
  - `crawl-reference.mjs` reports a site's type, palette, motion stack, performance, and accessibility, with screenshots.
  - `snapshot-site.mjs` and `compare-build.mjs` run ATM (Amati, Tiru, Modifikasi): a private copy to learn from, a rebuild scored for similarity, then a gate on originality before anything ships.
  - `build-tokens.mjs` turns a design tokens file into CSS variables or a Tailwind `@theme`.
  - A library shortlist, build-quality tells, and an Awwwards-style self-score.

The `deflow-ref` scripts need Playwright in your project:

```bash
npm i -D playwright && npx playwright install chromium
```

## Install

Install `weave-core` and `weave-ui` from agentic-weave, then the deflow skills:

```bash
npx agentic-weave install core ui -t claude -y
npx skills add cendysaputra/deflow
```

Or copy the folders in `skills/` into `~/.claude/skills/` or `~/.agents/skills/` next to `weave-core`.

In Claude Code, add both as plugins:

```text
/plugin marketplace add cendysaputra/agentic-weave
/plugin install agentic-weave@agentic-weave
/plugin marketplace add cendysaputra/deflow
/plugin install deflow@deflow
```

## Start a project

```bash
node <skill-dir>/scripts/flow.mjs init --mode build
node <skill-dir>/scripts/flow.mjs check
node <skill-dir>/scripts/flow.mjs status
```

Commit `.deflow/` with the project; it records the decisions. Never commit `atm/` or `reference-crawl/`.

Projects started with agentic-weave 1.x keep their state in `.weave/`. Rename the folder to `.deflow/` before running `flow.mjs`.

## Credits

deflow was split out of agentic-weave, which started from [antislop](https://github.com/miqdadbadjuber/anti-slop) by Miqdad Badjuber. Both copyright notices are kept in [`LICENSE`](LICENSE).

Contributors and agents working on this repository: read [`AGENTS.md`](AGENTS.md).
