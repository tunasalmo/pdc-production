import { createRoot } from 'react-dom/client';
import FlowingMenu from './components/FlowingMenu/FlowingMenu';

const mount = document.getElementById('category-menu');

if (mount) {
  const items = JSON.parse(mount.dataset.items || '[]');

  createRoot(mount).render(
    <FlowingMenu
      items={items}
      speed={15}
      textColor="#AFA9EC"
      bgColor="#0a0a0f"
      marqueeBgColor="#534AB7"
      marqueeTextColor="#ffffff"
      borderColor="rgba(175, 169, 236, 0.22)"
    />
  );
}
