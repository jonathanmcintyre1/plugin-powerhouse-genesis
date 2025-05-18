
import { toast } from '@/components/ui/use-toast';

// Type for a single settings group
type SettingsGroup = {
  type: string;
  data: any;
};

// Save settings to WordPress via AJAX
export const saveSettings = async (
  settingsGroups: SettingsGroup[],
  ajaxUrl?: string,
  nonce?: string
): Promise<boolean> => {
  if (!ajaxUrl || !nonce) {
    console.error('WordPress AJAX URL or nonce is missing');
    toast({
      title: 'Error',
      description: 'Could not save settings. WordPress configuration is missing.',
      variant: 'destructive',
    });
    return false;
  }

  try {
    for (const group of settingsGroups) {
      const formData = new FormData();
      formData.append('action', 'copyprotect_save_settings');
      formData.append('nonce', nonce);
      formData.append('settings_type', group.type);
      formData.append('settings', JSON.stringify(group.data));

      const response = await fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      });

      const result = await response.json();
      if (!result.success) {
        throw new Error(`Failed to save ${group.type}: ${result.data}`);
      }
    }

    toast({
      title: 'Success',
      description: 'Settings saved successfully.',
    });

    return true;
  } catch (error) {
    console.error('Error saving settings:', error);
    toast({
      title: 'Error',
      description: 'Failed to save settings. Please try again.',
      variant: 'destructive',
    });
    return false;
  }
};
