<style>
body.services-home-page {
  background:
    var(--brand-neutral);
}

body.services-home-page main {
  background: transparent;
}

.shm-shell {
  width: min(1380px, 94vw);
  margin: 0 auto;
}

.shm-section {
  padding: clamp(58px, 7vw, 102px) 0;
}

.shm-hero {
  position: relative;
  overflow: hidden;
  padding: clamp(74px, 9vw, 124px) 0 clamp(40px, 6vw, 70px);
  color: var(--brand-white);
  background:
    color-mix(in srgb, var(--brand-secondary) 92%, #000 8%);
}

.shm-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  pointer-events: none;
  background-image:
    none;
  background-size: 44px 44px;
  opacity: 0.25;
}

.shm-hero__grid {
  position: relative;
  z-index: 1;
  display: grid;
  grid-template-columns: minmax(0, 1.12fr) minmax(0, 0.88fr);
  gap: clamp(14px, 2.8vw, 28px);
  align-items: start;
}

.shm-hero__eyebrow {
  display: inline-flex;
  align-items: center;
  min-height: 32px;
  padding: 0 12px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.5);
  background: rgba(var(--brand-accent-rgb), 0.16);
  color: color-mix(in srgb, var(--brand-white) 88%, var(--brand-accent) 12%);
  font-size: 10px;
  letter-spacing: 1px;
  text-transform: uppercase;
  font-weight: 800;
}

.shm-hero__title {
  margin: 14px 0 0;
  color: var(--brand-white);
  font-size: clamp(2.4rem, 6vw, 4.9rem);
  line-height: 0.88;
}

.shm-hero__title strong {
  display: block;
  color: color-mix(in srgb, var(--brand-accent) 70%, var(--brand-white) 30%);
}

.shm-hero__desc {
  margin: 16px 0 0;
  max-width: 74ch;
  color: rgba(255, 255, 255, 0.84);
  line-height: 1.72;
}

.shm-hero__actions {
  margin-top: 18px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.shm-btn {
  min-height: 42px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 800;
  padding: 0 14px;
  border: 1px solid transparent;
  transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease;
}

.shm-btn:hover {
  transform: translateY(-2px);
}

.shm-btn--solid {
  background: var(--brand-accent);
  border-color: var(--brand-accent);
  color: var(--brand-white);
}

.shm-btn--line {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.34);
  color: var(--brand-white);
}

.shm-btn--ghost {
  background: rgba(0, 0, 0, 0.26);
  border-color: rgba(255, 255, 255, 0.22);
  color: color-mix(in srgb, var(--brand-white) 88%, var(--brand-neutral) 12%);
}

.shm-hero__stats {
  margin-top: 16px;
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 8px;
}

.shm-hero__stats article {
  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.08);
  padding: 10px;
}

.shm-hero__stats strong {
  display: block;
  color: var(--brand-white);
  font-size: clamp(0.92rem, 1.6vw, 1.08rem);
  line-height: 1.2;
}

.shm-hero__stats span {
  display: block;
  margin-top: 3px;
  color: rgba(255, 255, 255, 0.7);
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 700;
}

.shm-hero__panel {
  border: 1px solid rgba(255, 255, 255, 0.22);
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.12);
  padding: 14px;
  display: grid;
  gap: 10px;
}

.shm-hero__panel h2 {
  margin: 0;
  color: var(--brand-white);
  font-size: clamp(1.4rem, 2.4vw, 1.9rem);
  line-height: 0.95;
}

.shm-hero__panel p {
  margin: 0;
  color: rgba(255, 255, 255, 0.78);
  line-height: 1.6;
}

.shm-hero__panel-list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 8px;
}

.shm-hero__panel-list li {
  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 12px;
  background: rgba(0, 0, 0, 0.18);
  padding: 10px;
  display: flex;
  gap: 10px;
  align-items: flex-start;
}

.shm-hero__panel-list i {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.35);
  color: var(--brand-accent);
  background: rgba(var(--brand-accent-rgb), 0.12);
  flex: 0 0 auto;
}

.shm-hero__panel-list strong {
  display: block;
  color: var(--brand-white);
  font-size: 0.95rem;
  line-height: 1.25;
}

.shm-hero__panel-list span {
  display: block;
  margin-top: 2px;
  color: rgba(255, 255, 255, 0.72);
  font-size: 0.88rem;
  line-height: 1.4;
}

.shm-groups {
  padding: 28px 0 18px;
}

.shm-groups__grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 10px;
}

.shm-groups__card {
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
  border-radius: 14px;
  background: rgba(255, 255, 255, 0.84);
  box-shadow: 0 14px 26px rgba(var(--brand-secondary-rgb), 0.08);
  padding: 14px;
}

.shm-groups__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}

.shm-groups__head h3 {
  margin: 0;
  color: var(--brand-secondary);
  font-size: clamp(1.1rem, 2vw, 1.4rem);
  line-height: 1;
}

.shm-groups__head a {
  color: var(--brand-secondary);
  text-decoration: none;
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: 1px;
  font-weight: 800;
}

.shm-groups__card p {
  margin: 8px 0 0;
  color: color-mix(in srgb, var(--brand-secondary) 62%, var(--brand-white) 38%);
  line-height: 1.63;
}

.shm-groups__links {
  margin-top: 10px;
  display: flex;
  flex-wrap: wrap;
  gap: 7px;
}

.shm-groups__links a {
  min-height: 28px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.18);
  background: var(--brand-white);
  color: var(--brand-secondary);
  text-decoration: none;
  padding: 0 10px;
  display: inline-flex;
  align-items: center;
  text-transform: uppercase;
  letter-spacing: 0.9px;
  font-size: 10px;
  font-weight: 700;
}

.shm-directory {
  padding: 22px 0 clamp(62px, 7vw, 100px);
}

.shm-directory__head h2 {
  margin: 0;
  color: var(--brand-secondary);
  font-size: clamp(2rem, 4.4vw, 3.4rem);
  line-height: 0.92;
}

.shm-directory__head p {
  margin: 10px 0 0;
  max-width: 74ch;
  color: color-mix(in srgb, var(--brand-secondary) 64%, var(--brand-white) 36%);
  line-height: 1.7;
}

.shm-controls {
  margin-top: 12px;
  position: sticky;
  top: 80px;
  z-index: 24;
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.15);
  border-radius: 14px;
  background: rgba(255, 255, 255, 0.88);
  backdrop-filter: blur(8px);
  padding: 10px;
  display: grid;
  gap: 10px;
}

.shm-controls__top {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: center;
  justify-content: space-between;
}

.shm-search {
  position: relative;
  min-width: min(380px, 90vw);
  flex: 1 1 280px;
}

.shm-search input {
  width: 100%;
  min-height: 42px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.17);
  background: var(--brand-white);
  color: var(--brand-secondary);
  padding: 0 42px 0 42px;
}

.shm-search input:focus {
  outline: none;
  border-color: rgba(var(--brand-accent-rgb), 0.65);
  box-shadow: 0 0 0 4px rgba(var(--brand-accent-rgb), 0.16);
}

.shm-search i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: rgba(var(--brand-secondary-rgb), 0.56);
}

.shm-search button {
  position: absolute;
  right: 7px;
  top: 50%;
  transform: translateY(-50%);
  width: 30px;
  height: 30px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.16);
  background: color-mix(in srgb, var(--brand-neutral) 74%, var(--brand-white) 26%);
  color: var(--brand-secondary);
  cursor: pointer;
}

.shm-results {
  color: rgba(var(--brand-secondary-rgb), 0.66);
  font-size: 10px;
  letter-spacing: 1px;
  text-transform: uppercase;
  font-weight: 800;
}

.shm-filters {
  display: flex;
  flex-wrap: wrap;
  gap: 7px;
}

.shm-filter {
  min-height: 34px;
  border-radius: 999px;
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.2);
  background: var(--brand-white);
  color: var(--brand-secondary);
  font-size: 10px;
  letter-spacing: 1px;
  text-transform: uppercase;
  font-weight: 800;
  padding: 0 11px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
}

.shm-filter span {
  color: rgba(var(--brand-secondary-rgb), 0.58);
}

.shm-filter.is-active {
  background: var(--brand-secondary);
  border-color: var(--brand-secondary);
  color: var(--brand-white);
}

.shm-filter.is-active span {
  color: rgba(255, 255, 255, 0.72);
}

.shm-grid {
  margin-top: 12px;
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 10px;
}

.shm-card {
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
  border-radius: 14px;
  background: rgba(255, 255, 255, 0.92);
  box-shadow: 0 14px 30px rgba(var(--brand-secondary-rgb), 0.09);
  overflow: hidden;
  display: grid;
  transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
  scroll-margin-top: 148px;
}

.shm-card:hover {
  transform: translateY(-3px);
  border-color: rgba(var(--brand-accent-rgb), 0.5);
  box-shadow: 0 20px 36px rgba(var(--brand-secondary-rgb), 0.12);
}

.shm-card.is-hidden {
  display: none;
}

.shm-card.is-focused {
  border-color: rgba(var(--brand-accent-rgb), 0.9);
  box-shadow: 0 0 0 4px rgba(var(--brand-accent-rgb), 0.18), 0 18px 34px rgba(var(--brand-secondary-rgb), 0.14);
}

.shm-card__media {
  position: relative;
  height: 210px;
  overflow: hidden;
}

.shm-card__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.shm-card__group {
  position: absolute;
  left: 10px;
  top: 10px;
  min-height: 26px;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.25);
  background: rgba(var(--brand-secondary-rgb), 0.56);
  color: var(--brand-white);
  padding: 0 10px;
  display: inline-flex;
  align-items: center;
  text-transform: uppercase;
  letter-spacing: 0.9px;
  font-size: 9px;
  font-weight: 800;
}

.shm-card__body {
  padding: 12px;
  display: grid;
  gap: 9px;
}

.shm-card__top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
}

.shm-card__icon {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: 1px solid rgba(var(--brand-accent-rgb), 0.34);
  background: color-mix(in srgb, var(--brand-accent) 11%, var(--brand-white) 89%);
  color: var(--brand-accent);
}

.shm-card__code {
  color: rgba(var(--brand-secondary-rgb), 0.6);
  font-size: 10px;
  letter-spacing: 1px;
  text-transform: uppercase;
  font-weight: 900;
}

.shm-card h3 {
  margin: 0;
  color: var(--brand-secondary);
  font-size: clamp(1.2rem, 2vw, 1.5rem);
  line-height: 0.98;
}

.shm-card p {
  margin: 0;
  color: color-mix(in srgb, var(--brand-secondary) 64%, var(--brand-white) 36%);
  line-height: 1.64;
}

.shm-card__points {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  gap: 6px;
}

.shm-card__points li {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  color: color-mix(in srgb, var(--brand-secondary) 62%, var(--brand-white) 38%);
  line-height: 1.45;
  font-size: 0.9rem;
}

.shm-card__points i {
  color: var(--brand-accent);
  margin-top: 3px;
}

.shm-card__link {
  margin-top: 2px;
  min-height: 38px;
  border-radius: 12px;
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.16);
  background: color-mix(in srgb, var(--brand-neutral) 70%, var(--brand-white) 30%);
  color: var(--brand-secondary);
  text-decoration: none;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 10px;
  font-weight: 800;
  padding: 0 11px;
  display: inline-flex;
  align-items: center;
  justify-content: space-between;
}

.shm-cta {
  padding: 0 0 clamp(72px, 8vw, 110px);
}

.shm-cta__wrap {
  border: 1px solid rgba(var(--brand-secondary-rgb), 0.14);
  border-radius: 18px;
  background: color-mix(in srgb, var(--brand-neutral) 74%, var(--brand-white) 26%);
  box-shadow: 0 18px 36px rgba(var(--brand-secondary-rgb), 0.1);
  padding: clamp(16px, 2.6vw, 28px);
  display: grid;
  grid-template-columns: minmax(0, 1.08fr) minmax(0, 0.92fr);
  gap: 14px;
  align-items: start;
}

.shm-cta__copy h2 {
  margin: 0;
  color: var(--brand-secondary);
  font-size: clamp(1.9rem, 3.8vw, 3rem);
  line-height: 0.9;
}

.shm-cta__copy h2 strong {
  display: block;
  color: color-mix(in srgb, var(--brand-accent) 62%, var(--brand-secondary) 38%);
}

.shm-cta__copy p {
  margin: 10px 0 0;
  color: color-mix(in srgb, var(--brand-secondary) 65%, var(--brand-white) 35%);
  line-height: 1.68;
}

.shm-cta__meta {
  margin: 12px 0 0;
  padding: 0;
  list-style: none;
  display: grid;
  gap: 8px;
}

.shm-cta__meta li {
  display: flex;
  gap: 8px;
  align-items: flex-start;
  color: color-mix(in srgb, var(--brand-secondary) 64%, var(--brand-white) 36%);
  line-height: 1.5;
}

.shm-cta__meta i {
  color: var(--brand-accent);
  margin-top: 4px;
}

.shm-cta__actions {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(2, minmax(190px, 1fr));
  gap: 8px;
  align-content: start;
}

.shm-cta__actions .shm-btn {
  width: 100%;
  min-height: 42px;
  padding: 0 12px;
}

.shm-cta__actions .shm-btn--solid {
  background: var(--brand-accent);
  border-color: var(--brand-accent);
  color: var(--brand-white);
}

.shm-cta__actions .shm-btn--line {
  background: var(--brand-white);
  border-color: rgba(var(--brand-secondary-rgb), 0.2);
  color: var(--brand-secondary);
}

.shm-cta__actions .shm-btn--ghost {
  background: color-mix(in srgb, var(--brand-neutral) 80%, var(--brand-white) 20%);
  border-color: rgba(var(--brand-secondary-rgb), 0.18);
  color: var(--brand-secondary);
}

@media (max-width: 1120px) {
  .shm-hero__grid,
  .shm-cta__wrap {
    grid-template-columns: minmax(0, 1fr);
  }

  .shm-groups__grid {
    grid-template-columns: minmax(0, 1fr);
  }

  .shm-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .shm-cta__actions {
    grid-template-columns: repeat(2, minmax(170px, 1fr));
  }
}

@media (max-width: 820px) {
  .shm-hero__stats {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}

@media (max-width: 680px) {
  .shm-hero {
    padding: 62px 0 52px;
  }

  .shm-controls {
    top: 70px;
  }

  .shm-grid {
    grid-template-columns: minmax(0, 1fr);
  }

  .shm-hero__stats {
    grid-template-columns: minmax(0, 1fr);
  }

  .shm-search {
    min-width: 100%;
  }

  .shm-btn {
    width: 100%;
  }

  .shm-cta__actions {
    grid-template-columns: 1fr;
  }
}
</style>
