import { createRoot } from 'react-dom/client';
import Beams from './components/Beams/Beams';

const mount = document.getElementById('hero-beams');

if (mount) {
  createRoot(mount).render(
    <Beams
      beamWidth={2}
      beamHeight={15}
      beamNumber={12}
      lightColor="#b1d4fc" 
      speed={2}
      noiseIntensity={1.75}
      scale={0.2}
      rotation={0}
    />
  );
}
